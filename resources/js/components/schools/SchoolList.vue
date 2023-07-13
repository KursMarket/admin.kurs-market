<template>
    <section class="section">
        <span class="mb-2">Всего школ: {{ total }}</span>
        <div class="row">
            <div class="col-lg-12">
                <add-button :url="addUrl" />
                <div class="search">
                    <img src="/assets/img/icons/search.png" class="me-2 search-icon" alt="" @click="findResultsBySearch">
                    <input type="text" class="form-control" v-model="search" placeholder="Поиск" @keydown="searchResults">
                    <a href="" class="btn" @click.prevent="resetSearch">Сбросить</a>
                </div>
                <div class="action-panel" ref="schoolsBar">
                    <div class="list-actions">
                        <a href="" @click.prevent="removeMultipe"><img src="/assets/img/icons/bi_trash3.png" alt="">Удалить</a>
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
                <div class="card">
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
                                        :checked="userIds.length === schools.length">
                                </th>
                                <th scope="col">id</th>
                                <th scope="col">Название</th>
                                <th scope="col">Кол-во курсов</th>
                                <th scope="col">Статус</th>
                                <th scope="col">Дата регистрации</th>
                                <th scope="col"></th>
                            </tr>
                            </thead>
                            <tbody v-if="schools.length">
                            <tr v-for="school in schools" :key="`school-${school.id}`">
                                <td>
                                    <input
                                        type="checkbox"
                                        class="form-check"
                                        v-model="userIds"
                                        :value="school.id"
                                        :checked="userIds.includes(school.id)"
                                        @change="checkCurrentSchool(school.id, $event)"
                                    >
                                </td>
                                <th scope="row">{{ school.id }}</th>
                                <td>{{ school.name }}</td>
                                <td>{{ school.courseCount }}</td>
                                <td><div class="form-check form-switch">
                                    <input
                                        class="form-check-input"
                                        type="checkbox"
                                        id="flexSwitchCheckCheckedDisabled"
                                        :checked="school.status"
                                        @change.prevent="changeStatus(school.id, $event)"
                                    >
                                </div></td>
                                <td>{{ school.dateRegister }}</td>
                                <td>
                                    <a :href="`/schools/${school.id}/edit`" class="btn edit"><img src="/assets/img/icons/bi_pencil.png" alt="">Редактировать</a>
                                </td>
                            </tr>
                            </tbody>
                            <tbody v-else>
                                <tr>
                                    <td colspan="5">Школы отсутствуют</td>
                                </tr>
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
</template>

<script>
import API from "../../helpers/api";
import AddButton from "../general/AddButton";

export default {
    name: "SchoolList",
    props: {
        addUrl: {
            type: String,
            required: true
        }
    },
    components: {
        AddButton
    },
    data: () => ({
        schools: [],
        total: 0,
        search: '',
        countPage: 20,
        isCountPageShowing: false,
        userIds: [],
        allSelected: false,
        page: 1,
    }),
    computed: {
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
        }
    },
    created() {
        this.getSchools(this.page);
    },
    methods: {
        pageChangeHandler(page) {
            this.page = page;
            this.getSchools(this.page);
            this.$refs.schoolsBar.scrollIntoView();
        },
        async getSchools(page) {
            const filters = {
                limit: this.countPage,
                search: this.search,
                offset: this.pageOffset
            };
            await API.schoolsEndpoint.getAllSchools(filters, page)
                .then(response => {
                    this.schools = response.data.data.results;
                    this.total = response.data.data.total;
                })
        },
        changeStatus(schoolId, e) {
            API.schoolsEndpoint.changeStatuses([schoolId], e.target.checked);
        },
        async changeMultipleStatuses(status) {
            await API.schoolsEndpoint.changeStatuses(this.userIds, status)
                .then(() => {
                    this.getSchools();
                    this.userIds = [];
                })

        },
        async removeMultipe() {
            if (confirm('Вы хотите удалить из системы школы, которые не смогут быть восстановлены. Вы уверены?')) {
                await API.schoolsEndpoint.removeSchools(this.userIds)
                    .then(() => {
                        this.getSchools();
                        this.userIds = [];
                    })
            }
        },
        findResultsBySearch() {
            this.page = 1;
            this.getSchools(this.page);
        },
        resetSearch() {
            this.search = '';
            this.page = 1;
            this.getSchools(this.page);
        },
        searchResults(e) {
            if (e.keyCode === 13) {
                this.findResultsBySearch();
            }
        },
        setCurrent(count) {
            this.countPage = count;
            this.isCountPageShowing = false;
            this.getSchools();
        },
        selectAllCheckboxes(e) {
            this.userIds = [];
            if (e.target.checked) {
                if (this.schools.length) {
                    for (const s in this.schools) {
                        this.userIds.push(this.schools[s].id)
                    }
                }
            }
        },
        checkCurrentSchool(id, e) {
            if (!e.target.checked) {
                this.userIds = this.userIds.filter(s => s !== id);
            } else {
                if (!this.userIds.find(s => s === id)) {
                    this.userIds.push(id);
                }
            }
        }
    }
}
</script>

<style scoped lang="scss">

</style>
