<template>
    <section class="section">
        <div class="row">
            <div class="col-12">

                <div class="card" ref="formHandlerRefs">
                    <div class="card-body">
                        <h5 class="card-title"><a :href="backUrl">{{ '< назад' }}</a></h5>

                        <!-- General Form Elements -->
                        <form @submit.prevent="formHandler">
                            <div v-if="reviewId" class="row col-6 mb-3">
                                <label class="col-sm-2 col-form-label">ID</label>
                                <div class="col-sm-10">
                                    <input type="text" v-model="form.id" :disabled="true" class="form-control">
                                    <div v-if="arrayKeyExists('id', errors)" class="invalid-feedback">{{
                                            errors.id
                                        }}
                                    </div>
                                </div>
                            </div>

                            <div class="row col-6 mb-3">
                                <label class="col-sm-2 col-form-label">Школа</label>
                                <div class="col-sm-10">
                                    <vue-select
                                        v-model="form.school_id"
                                        :options="schools"
                                        :settings="{
                                            placeholder: '-- Выбрать --',
                                            language: {noResults: () => 'Школы(ы) не найдена(ы)'},
                                            allowClear: true
                                        }"
                                    ></vue-select>
                                    <div v-if="arrayKeyExists('school_id', errors)" class="invalid-feedback">
                                        {{ errors.school_id }}
                                    </div>
                                </div>
                            </div>

                            <div class="row col-6 mb-3">
                                <label class="col-sm-2 col-form-label">Курс</label>
                                <div class="col-sm-10">
                                    <vue-select
                                        v-model="form.course_id"
                                        :options="coursesListForSchool"
                                        :settings="{
                                            placeholder: '-- Выбрать --',
                                            language: {noResults: () => 'Курс(ы) не найден(ы)'}
                                        }"
                                    ></vue-select>
                                    <div v-if="arrayKeyExists('course_id', errors)" class="invalid-feedback">
                                        {{ errors.course_id }}
                                    </div>
                                </div>
                            </div>

                            <div class="row col-6 mb-3">
                                <label class="col-sm-2 col-form-label">Статус</label>
                                <div class="col-sm-10">
                                    <vue-select
                                        v-model="form.status"
                                        :options="statuses"
                                        :settings="{
                                            placeholder: '-- Выбрать --',
                                            language: {noResults: () => 'Статус не найден'}
                                        }"
                                    ></vue-select>
                                </div>
                            </div>

                            <div class="row col-6 mb-3">
                                <label class="col-sm-2 col-form-label">Источник</label>
                                <div class="col-sm-10">
                                    <vue-select
                                        v-model="form.source"
                                        :options="sources"
                                        :settings="{
                                            placeholder: '-- Выбрать --',
                                            language: {noResults: () => 'Источник не найден'}
                                        }"
                                    ></vue-select>
                                </div>
                            </div>

                            <div class="row col-6 mb-3">
                                <label class="col-sm-2 col-form-label">Автор</label>
                                <div class="col-sm-10">
                                    <vue-select
                                        v-model="form.user_id"
                                        :options="users"
                                        :settings="{
                                            placeholder: '-- Выбрать --',
                                            language: {noResults: () => 'Пользова не найден'}
                                        }"
                                    ></vue-select>
                                </div>
                            </div>

                            <div class="row col-6 mb-3">
                                <label class="col-sm-2 col-form-label">Оценка</label>
                                <div class="col-sm-10">
                                    <input type="text" v-model="form.grade" class="form-control">
                                    <div v-if="arrayKeyExists('grade', errors)" class="invalid-feedback">{{
                                            errors.grade
                                        }}
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-12">
                                    <label for="additional_description" class="form-label">Текст</label>
                                    <textarea class="form-control" rows="10" id="additional_description"
                                              v-model="form.text"></textarea>
                                    <div v-if="arrayKeyExists('additional_description', errors)"
                                         class="invalid-feedback">{{ errors.text }}
                                    </div>
                                </div>
                            </div>

                            <div class="col-6 mt-4">
                                <label for="from" class="form-label">Дата</label>
                                <date
                                    id="from"
                                    v-model="form.created_at"
                                    :placeholder="new Date().toLocaleDateString('ru')"
                                    locale="ru"
                                    format="dd.MM.Y"
                                    :enable-time-picker="false"
                                ></date>
                            </div>

                            <div class="col-12 mt-4">
                                <h5>Дополнительное управление</h5>
                                <fieldset class="row mb-3 mt-3">
                                    <legend class="col-form-label col-sm-2 pt-0">Выводить</legend>
                                    <div class="col-sm-10">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="show_on_home_page" v-model="form.show_on_home_page">
                                            <label class="form-check-label" for="show_on_home_page">
                                                На главной странице
                                            </label>
                                        </div>
                                    </div>
                                </fieldset>
                                <div class="row mb-3">
                                    <label class="form-check-label col-sm-2" for="sort_order_on_home_page">
                                        Сортировка на главной странице
                                    </label>
                                    <div class="col-sm-10">
                                        <input type="number" class="form-control" id="sort_order_on_home_page" v-model="form.sort_order_on_home_page">
                                    </div>
                                </div>
                            </div>

                            <div class="text-center mt-5">
                                <button type="submit" class="btn btn-primary">Сохранить</button>
                                <a :href="backUrl" class="btn btn-secondary ms-2" style="color: #fff;">Назад</a>
                            </div>
                        </form>

                    </div>
                </div>

            </div>
        </div>
    </section>
    <flash-message
        :duration="3000"
    />
</template>

<script>
import Select2 from "vue3-select2-component";
import API from "../../helpers/api";
import NotificationHelper from "../../modules/notifications";
import FlashMessage from "../notifications/FlashMessage";
import vfMixins from "../../mixins/validation";
import VueDatePicker from '@vuepic/vue-datepicker';

export default {
    name: "ReviewEdit",
    mixins: [vfMixins],
    components: {
        vueSelect: Select2,
        FlashMessage,
        date: VueDatePicker,
    },
    props: {
        backUrl: {
            type: String,
            required: false,
            default: ''
        },
        reviewId: {
            type: [String, Number],
            required: false,
            default: null
        }
    },
    data: () => ({
        statuses: [],
        sources: [],
        schools: [],
        courses: [],
        errors: [],
        users: [],
        form: {
            id: '',
            school_id: '',
            course_id: '',
            user_id: '',
            grade: '',
            text: '',
            status: '',
            source: '',
            created_at: '',
            show_on_home_page: false,
            sort_order_on_home_page: 0,
        }
    }),
    computed: {
        coursesListForSchool() {
            return this.form.school_id ? this.courses.filter((course) => course.school_id === +this.form.school_id) : this.courses;
        }
    },
    methods: {
        async loadSchools() {
            await API.reviewEndpoint.getSchoolsList()
                .then(response => {
                    this.schools = response.data.data.results;
                })
        },
        async loadCourses() {
            await API.reviewEndpoint.getCoursesList()
                .then(response => {
                    this.courses = response.data.data.results;
                })
        },
        async loadStatusesList() {
            await API.reviewEndpoint.getStatusesList()
                .then(response => {
                    this.statuses = response.data.data;
                })
        },
        async loadSourcesList() {
            await API.reviewEndpoint.getSourcesList()
                .then(response => {
                    this.sources = response.data.data;
                })
        },
        async loadReview() {
            await API.reviewEndpoint.getReview(this.reviewId)
                .then(response => {
                    const review = response.data.data;
                    this.loadFormDataFromResponse(review);
                })
        },
        loadFormDataFromResponse(review) {
            this.form.id = review.id;
            this.form.school_id = review.school.user_id;
            this.form.course_id = review.course.id;
            this.form.user_id = review.user_id;
            this.form.author = review.author;
            this.form.email = review.email;
            this.form.grade = review.grade;
            this.form.text = review.text;
            this.form.status = review.status;
            this.form.source = review.source;
            this.form.created_at = review.created_at;
            this.form.show_on_home_page = review.show_on_home_page;
            this.form.sort_order_on_home_page = review.sort_order_on_home_page;
        },
        async formHandler() {
            if (this.reviewId) {
                this.form.id = this.reviewId;
            }

            const fd = new FormData();
            for (const i in this.form) {
                fd.append(i, this.form[i]);
            }

            await API.reviewEndpoint.save(fd)
                .then(response => {
                    if (response.data.status) {
                        window.location.href = this.backUrl;
                    }
                }).catch(errors => {
                    this.errors = this.errorsAnswerHandling(errors);
                    console.log(this.errors)
                    NotificationHelper.showError('При заполнении формы возникли ошибки!');
                    this.$refs.formHandlerRefs.scrollIntoView();
                })
        },
        async loadUsersList() {
            await API.reviewEndpoint.getUsersList().then(response => {
                if (response.data.status) {
                    this.users = response.data.data.users;
                }
            })
        },
    },
    mounted() {
        this.loadSchools();
        this.loadCourses();
        this.loadStatusesList();
        this.loadSourcesList();
        this.loadUsersList();
        if (this.reviewId) {
            this.loadReview();
        }
    },
}
</script>

<style lang="scss" scoped>
.ul--tags {
    padding: 0;
    margin: 0 0 36px 0;
    list-style-type: none;
    display: flex;
    align-items: center;
    justify-content: flex-start;

    & li {
        border: 1px solid #DBDBDB;
        border-radius: 5px;
        margin-right: 10px;
    }
}

.invalid-feedback {
    display: block !important;
}
</style>

