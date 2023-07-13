<template>
    <section class="section">
        <div class="row">
            <div class="col-12">
                <div class="col-3 mb-3">
                    <span class="mb-1">Всего отзывов: {{ getTotalReviews }}</span>
                </div>
                <div class="row" v-html="reviewLab"></div>
                <div class="col-12">
                    <add-button :url="'/reviews/create'" :classes="'mt-3'" />
                </div>
                <span class="import-span">Чтобы массово разместить курсы, воспользуйтесь <a href="#" class="btn import-a">Импортом отзывов</a></span>

                <div class="action-panel mt-3">
                    <div class="list-actions">
                        <a href="" @click.prevent="removeMultiple"><img src="/assets/img/icons/bi_trash3.png" alt="">Удалить</a>
                        <a href="" @click.prevent="changeMultipleStatuses(false)"><img src="/assets/img/icons/bi_eye-slash.png" alt="">Скрыть</a>
                        <a href="" @click.prevent="changeMultipleStatuses(true)"><img src="/assets/img/icons/bi_eye.png" alt="">Опубликовать</a>
                    </div>
                    <div class="panel-show">
                        <div class="show" @click="isCountPageShowing = !isCountPageShowing">
                            Показывать: {{ countPage }} <img src="/assets/img/icons/dropdown.png" alt="" :class="isCountPageShowing ? 'rotated' : ''">
                        </div>

                        <div class="other" v-if="isCountPageShowing">
                            <a
                                href=""
                                @click.prevent="setCurrent(count.count)"
                                :class="count.count === countPage ? 'current' : ''"
                                v-for="count in displayAllCounts"
                                :key="`cnt-${count.count}`"
                            >{{ count.count }}</a>
                        </div>
                    </div>
                </div>

                <div class="card mt-4">
                    <div class="card-body">
                        <table class="table">
                            <thead>
                            <tr>
                                <th scope="col">
                                    <input
                                        type="checkbox"
                                        class="form-check"
                                        @change="selectAllCheckboxes"
                                        v-model="allSelected"
                                        :checked="ids.length === reviews.length">
                                </th>
                                <th scope="col">ID</th>
                                <th scope="col">Школа</th>
                                <th scope="col">Курс</th>
                                <th scope="col">Автор</th>
                                <th scope="col">Статус</th>
                                <th scope="col">Дата добавления</th>
                                <th scope="col">Источник</th>
                                <th scope="col"></th>
                            </tr>
                            </thead>
                            <tbody>
                            <template v-if="reviews.length">
                                <tr v-for="(review, key) in reviews" :key="key">
                                    <th scope="row">
                                        <input
                                            type="checkbox"
                                            class="form-check"
                                            v-model="ids"
                                            :value="review.id"
                                            :checked="ids.includes(review.id)"
                                            @change="checkCurrentCourse(review.id, $event)"
                                        >
                                    </th>
                                    <td>{{ review.id }}</td>
                                    <td>{{ review.school?.name }}</td>
                                    <td>{{ review.course?.title }}</td>
                                    <td>{{ review.author }}</td>
                                    <td v-if="review.status === 'published'">
                                        <span style='display:flex;align-items: center;'><span style='display: inline-block;width: 10px;height: 10px;background-color: #9DC892;margin-right:5px;'></span><span>Опубликован</span></span>
                                    </td>
                                    <td v-if="review.status === 'rejected'">
                                        <span style='display:flex;align-items: center;'><span style='display: inline-block;width: 10px;height: 10px;background-color: #D75D5D;margin-right:5px;'></span><span>Отклонен</span></span>
                                    </td>
                                    <td v-if="review.status === 'moderation'">
                                        <span style='display:flex;align-items: center;'><span style='display: inline-block;width: 10px;height: 10px;background-color: #F3E4AB;margin-right:5px;'></span><span>На модерации</span></span>
                                    </td>
                                    <td>{{ review.created_at }}</td>
                                    <td>{{ review.source }}</td>
                                    <td>
                                        <a :href="`/reviews/${review.id}/edit`" class="btn edit">
                                            <img src="/assets/img/icons/bi_pencil.png" alt="">Редактировать
                                        </a>
                                    </td>
                                </tr>
                            </template>
                            <template v-else>
                                <tr>
                                    <td colspan="8">Ничего не найдено</td>
                                </tr>
                            </template>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <paginate
            v-if="countTotalPageForPagination > 1"
            :page-count="countTotalPageForPagination"
            :click-handler="pageChangeHandler"
            :prev-text="'«'"
            :next-text="'»'"
            :force-page="page"
            :container-class="'pagination'"
        >
        </paginate>
    </section>
    <flash-message
        :duration="3000"
    />
</template>

<script>
import API from "../../helpers/api";
import Select2 from "vue3-select2-component";
import vfMixins from "../../mixins/validation";
import NotificationHelper from "../../modules/notifications";
import FlashMessage from "../notifications/FlashMessage";
import VueDatePicker from '@vuepic/vue-datepicker';
import '@vuepic/vue-datepicker/dist/main.css'
import AddButton from "../general/AddButton";
import formatDate from "../../mixins/formatDate";

export default {
    name: "ReviewsList",
    mixins: [vfMixins, formatDate],
    components: {
        vueSelect: Select2,
        FlashMessage,
        date: VueDatePicker,
        AddButton
    },
    data: () => ({
        page: 1,
        countPage: 20,
        reviews: [],
        ids: [],
        total: 0,
        allSelected: false,
        isCountPageShowing: false,
        reviewLab: `
            <review-lab-simple class="col-3" data-widgetid="62a078d2903e11453741293b"></review-lab-simple>
            <review-lab-simple class="col-3" data-widgetid="629781646daca008ba867711"></review-lab-simple>
            <review-lab-simple class="col-3" data-widgetid="62a08332903e115900424101"></review-lab-simple>
        `,
    }),
    computed: {
        cancelCalendarText() {
            return 'Отмена';
        },
        selectCalendarText() {
            return 'Выбрать';
        },
        displayAllCounts() {
            return [
                {count: 10},
                {count: 20},
                {count: 30},
                {count: 40},
                {count: 50},
            ];
        },
        countTotalPageForPagination() {
            return Math.ceil(this.total/this.countPage);
        },
        pageOffset() {
            return (this.page - 1) * this.countPage;
        },
        getTotalReviews() {
            return new Intl.NumberFormat('ru', {
                maximumSignificantDigits: 3
            }).format(this.total);
        },
    },
    methods: {
        async getReviews(page) {
            const filters = {
                limit: this.countPage,
                offset: this.pageOffset
            };

            await API.reviewEndpoint.getReviews({...filters}, page)
                .then(response => {
                    this.reviews = response.data.data.reviews.data;
                    this.total = response.data.data.total;
                })
        },
        pageChangeHandler(page) {
            this.page = page;
            this.getReviews(this.page);
            this.$refs.coursesBar.scrollIntoView();
        },
        selectAllCheckboxes(e) {
            this.ids = [];
            if (e.target.checked) {
                if (this.reviews.length) {
                    for (const s in this.reviews) {
                        this.ids.push(this.reviews[s].id)
                    }
                }
            }
        },
        checkCurrentCourse(id, e) {
            if (!e.target.checked) {
                this.ids = this.ids.filter(s => s !== id);
            } else {
                if (!this.ids.find(s => s === id)) {
                    this.ids.push(id);
                }
            }
        },
        removeMultiple() {
            API.reviewEndpoint.removeMultiple(this.ids)
                .then(() => {
                    this.getReviews(this.page);
                });
        },
        changeMultipleStatuses(status) {
            if (confirm('Вы уверены?')) {
                API.reviewEndpoint.changeStatus(this.ids, status)
                    .then(response => {
                        if (response.data.status) {
                            this.getReviews(this.page);
                            this.ids = [];
                        }
                    })
            }
        },
        setCurrent(count) {
            this.countPage = count;
            this.isCountPageShowing = false;
            this.getReviews(this.page);
        },
        mountReviewLabScript() {
            let reviewLabScript = document.createElement('script')
            reviewLabScript.setAttribute('src', 'https://app.reviewlab.ru/widget/index-simple.js')
            document.head.appendChild(reviewLabScript)
        },
    },
    mounted() {
        this.getReviews(this.page);
        this.mountReviewLabScript()
    },
}
</script>

<style lang="scss" scoped>
.btn{
    &.position-absolute{
        right: -60px;
        bottom: 12px;
        width: 63px;
        height: 21px;
        font-weight:400;
        font-size: 16px;
        line-height: 21px;
    }
}
.import-span{
    display: block;
    & a{
        color: #D75D5D;
        text-decoration: underline;
        padding: 0;
        font-weight: 400;
        font-size: 16px;

    }
}
img{
    &.absolute-center{
        cursor: pointer;
    }
}
</style>
