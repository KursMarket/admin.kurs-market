<template>
    <section class="section">
        <span class="mb-2">Всего курсов: {{ getTotalCourses }}</span>
        <div class="row">
            <div class="col-8 position-relative">
                <img src="/assets/img/icons/search.png" alt="Search" class="position-absolute absolute-center" @click="findResultsBySearch">
                <input
                    type="text"
                    class="form-control ps-5"
                    v-model="form.search"
                    placeholder="Поиск по названию школы или курса"
                    @keydown="searchResults"
                >
            </div>
            <div class="col-8 pt-4">
                <div class="row position-relative">
                    <div class="col-6">
                        <label for="school" class="form-label">Школа</label>
                        <vue-select
                            id="school"
                            name="school"
                            v-model="form.school"
                            :options="schools"
                            :settings="{
                                placeholder: '-- Выбрать --',
                                language: {noResults: () => 'Школ(ы) не найдено(ы)'}
                            }"
                            @select="findResultsBySearch"
                        ></vue-select>

                    </div>
                    <div class="col-6">
                        <label for="status" class="form-label">Статус</label>
                        <vue-select
                            v-model="form.status"
                            :options="statuses"
                            id="status"
                            name="status"
                            :settings="{
                                placeholder: '-- Выбрать --',
                                language: {noResults: () => 'Статус(ы) не найден(ы)'},
                                templateResult: (state) => {
                                    return `<span>
                                                <span
                                                    style='display:inline-block;width:10px;height:10px;background-color:${state.color};margin-right:5px;'>
                                                </span>${state.text}
                                            </span>`;
                                },
                                escapeMarkup: (m) => m
                            }"
                            @select="findResultsBySearch"
                        ></vue-select>
                    </div>
                    <div class="col-6 mt-4">
                        <label for="categories" class="form-label">Категория</label>
                        <vue-select
                            id="categories"
                            name="categories"
                            v-model="form.category"
                            :options="categories"
                            :settings="{
                                placeholder: '-- Выбрать --',
                                language: {noResults: () => 'Категория(и) не найдена(ы)'}
                            }"
                            @select="getSubCategories($event)"
                        ></vue-select>

                    </div>
                    <div class="col-6 mt-4">
                        <label for="subcategories" class="form-label">Подкатегория</label>
                        <vue-select
                            id="subcategories"
                            name="subcategories"
                            v-model="form.sub_category"
                            :options="subcategories"
                            :settings="{
                                placeholder: '-- Выбрать --',
                                language: {noResults: () => 'Категория(и) не найдена(ы)'}
                            }"
                            @select="findResultsBySearch"
                        ></vue-select>
                    </div>
                    <div class="col-6 mt-4">
                        <label for="from" class="form-label">Дата с</label>
                        <date
                            id="from"
                            v-model="form.date_from"
                            :placeholder="new Date().toLocaleDateString('ru')"
                            locale="ru"
                            format="dd.MM.Y"
                            :enable-time-picker="false"
                            :cancelText="cancelCalendarText"
                            :selectText="selectCalendarText"
                            @update:model-value="findResultsBySearch"
                        ></date>
                    </div>
                    <div class="col-6 mt-4">
                        <label for="to" class="form-label">Дата до</label>
                        <date
                            id="to"
                            v-model="form.date_to"
                            :placeholder="new Date().toLocaleDateString('ru')"
                            locale="ru"
                            format="dd.MM.Y"
                            :enable-time-picker="false"
                            :cancelText="cancelCalendarText"
                            :selectText="selectCalendarText"
                            @update:model-value="findResultsBySearch"
                        ></date>
                    </div>
                    <span @click.prevent="resetFilter" class="btn position-absolute">Сбросить</span>
                </div>
            </div>
            <div class="col-12" ref="coursesBar">
                <add-button :url="'/courses/create'" :classes="'mt-3'" />
                <span class="import-span">Чтобы массово разместить курсы, воспользуйтесь <a href="#" class="btn import-a">Импортом курсов</a></span>

                <div class="action-panel mt-5">
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
                                        :checked="ids.length === courses.length">
                                </th>
                                <th scope="col">ID</th>
                                <th scope="col">Название</th>
                                <th scope="col">Школа</th>
                                <th scope="col">Статус</th>
                                <th scope="col">Дата добавления</th>
                                <th scope="col">Цена</th>
                                <th scope="col"></th>
                            </tr>
                            </thead>
                            <tbody>
                            <template v-if="courses.length">
                                <tr v-for="(course, key) in courses" :key="key">
                                    <th scope="row">
                                        <input
                                            type="checkbox"
                                            class="form-check"
                                            v-model="ids"
                                            :value="course.id"
                                            :checked="ids.includes(course.id)"
                                            @change="checkCurrentCourse(course.id, $event)"
                                        >
                                    </th>
                                    <td>{{ course.id }}</td>
                                    <td>{{ course.title }}</td>
                                    <td>{{ course.school?.name }}</td>
                                    <td v-html="course.status"></td>
                                    <td>{{ course.createdAt }}</td>
                                    <td>{{ getPriceInFormat(course.price) }}</td>
                                    <td>
                                        <a :href="`/courses/${course.id}/edit`" class="btn edit"><img src="/assets/img/icons/bi_pencil.png" alt="">Редактировать</a>
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

export default {
    name: "CoursesList",
    mixins: [vfMixins],
    components: {
        vueSelect: Select2,
        FlashMessage,
        date: VueDatePicker,
        AddButton
    },
    data: () => ({
        schools: [],
        statuses: [],
        categories: [],
        subcategories: [],
        page: 1,
        countPage: 20,
        courses: [],
        ids: [],
        total: 0,
        allSelected: false,
        isCountPageShowing: false,
        form: {
            search: '',
            school: '',
            status: '',
            category: '',
            sub_category: '',
            date_from: '',
            date_to: '',
        }
    }),
    created() {
        this.getSchools();
        this.getStatuses();
        this.getCategories();
        this.getCourses(this.page);
    },
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
        getTotalCourses() {
            return new Intl.NumberFormat('ru', {
                maximumSignificantDigits: 3
            }).format(this.total);
        },
    },
    methods: {
        resetFilter() {
            this.form.search = '';
            this.form.school = '';
            this.form.status = '';
            this.form.category = '';
            this.form.sub_category = '';
            this.form.date_from = '';
            this.form.date_to = '';
            this.getCourses(this.page);
        },
        getSchools() {
            API.courseEndpoint.getAllSchools()
                .then(response => {
                    this.schools = response.data.data.results;
                })
        },
        getStatuses() {
            API.courseEndpoint.getStatuses()
                .then(response => {
                    this.statuses = response.data.data.results;
                })
        },
        getCategories() {
             API.courseEndpoint.getCategories()
                .then(response => {
                    this.categories = response.data.data.results;
                })
        },
        async getSubCategories(val) {
            await API.courseEndpoint.getSubCategory(val.id)
                .then(response => {
                    this.subcategories = response.data.data.results;
                    this.findResultsBySearch()
                }).catch(errors => {
                    console.log(errors.response.data);
                    NotificationHelper.showError("Непредвиденная ошибка. Повторите попытку.");
                })
        },
        async getCourses(page) {
            const filters = {
                limit: this.countPage,
                offset: this.pageOffset
            };

            await API.courseEndpoint.getCourses({...filters, ...this.form}, page)
                .then(response => {
                    this.courses = response.data.data.courses;
                    this.total = response.data.data.total;
                })
        },
        pageChangeHandler(page) {
            this.page = page;
            this.getCourses(this.page);
            this.$refs.coursesBar.scrollIntoView();
        },
        selectAllCheckboxes(e) {
            this.ids = [];
            if (e.target.checked) {
                if (this.courses.length) {
                    for (const s in this.courses) {
                        this.ids.push(this.courses[s].id)
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
        getPriceInFormat(price) {
            return new Intl.NumberFormat('ru', {
                style: 'currency',
                currency: 'RUB'
            }).format(price);
        },
        removeMultiple() {
            API.courseEndpoint.removeMultiple(this.ids)
                .then(() => {
                    this.getCourses(this.page);
                });
        },
        changeMultipleStatuses(status) {
            if (confirm('Вы уверены?')) {
                API.courseEndpoint.changeStatus(this.ids, status)
                    .then(response => {
                        if (response.data.status) {
                            this.getCourses(this.page);
                            this.ids = [];
                        }
                    })
            }
        },
        setCurrent(count) {
            this.countPage = count;
            this.isCountPageShowing = false;
            this.getCourses(this.page);
        },
        async searchResults(e) {
            if (e.keyCode === 13) {
                this.findResultsBySearch();
            }
        },
        findResultsBySearch() {
            this.getCourses(this.page)
        }
    }
}
</script>

<style scoped lang="scss">
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
