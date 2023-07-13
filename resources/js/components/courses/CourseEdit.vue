<template>
    <section class="section">
        <div class="row">
            <div class="col-12">

                <div class="card" ref="formHandlerRefs">
                    <div class="card-body">
                        <h5 class="card-title"><a :href="backUrl">{{ '< назад' }}</a></h5>

                        <!-- General Form Elements -->
                        <form @submit.prevent="formHandler">
                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label">Название</label>
                                <div class="col-sm-10">
                                    <input type="text" v-model="form.title" class="form-control">
                                    <div v-if="arrayKeyExists('title', errors)" class="invalid-feedback">{{ errors.title }}</div>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label">Префикс к названию</label>
                                <div class="col-sm-10">
                                    <input type="text" v-model="form.prefix" class="form-control">
                                    <div v-if="arrayKeyExists('prefix', errors)" class="invalid-feedback">{{ errors.prefix }}</div>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label">Школа</label>
                                <div class="col-sm-10">
                                    <vue-select
                                        id="schools"
                                        name="schools"
                                        v-model="form.school"
                                        :options="schools"
                                        :settings="{
                                            placeholder: '-- Выбрать --',
                                            language: {noResults: () => 'Школы(ы) не найдена(ы)'}
                                        }"
                                    ></vue-select>
                                    <div v-if="arrayKeyExists('school', errors)" class="invalid-feedback">{{ errors.school }}</div>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label">Ссылка на курс</label>
                                <div class="col-sm-10">
                                    <input type="text" v-model="form.source_link" class="form-control">
                                    <div v-if="arrayKeyExists('source_link', errors)" class="invalid-feedback">{{ errors.source_link }}</div>
                                </div>
                            </div>

                            <h5 class="card-title">Категория курсов</h5>

                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label">Категория</label>
                                <div class="col-sm-10">
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
                            </div>
                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label">Подкатегория</label>
                                <div class="col-sm-10">
                                    <div class="row">
                                        <template v-for="(c, index) in selectedSubcategories" :key="c.id">
                                            <div class="col-10">
                                                <vue-select
                                                    :class="selectedSubcategories.length > 1 ? 'mt-2' : ''"
                                                    :id="`subcategories${index}`"
                                                    name="subcategories[]"
                                                    v-model="form.sub_category[index]"
                                                    :options="subcategories"
                                                    :settings="{
                                                        placeholder: '-- Выбрать --',
                                                        language: {noResults: () => 'Категория(и) не найдена(ы)'}
                                                    }"
                                                    @select="setSubcategory($event)"
                                                ></vue-select>
                                            </div>
                                            <div class="col-2">
                                                <button class="btn" @click.prevent="removeSelectedCategory(c.id, index)">
                                                    <img src="/assets/img/icons/bi_minus-circle.png" alt="Delete">
                                                </button>
                                            </div>
                                        </template>
                                    </div>

                                </div>
                                <div class="col-sm-4 offset-sm-6">
                                    <button
                                        :class="selectedSubcategories.length > 0 ? 'btn me-2 mt-2' : 'btn me-2'"
                                        @click.prevent="setSubcategory(null)"
                                        :disabled="subcategories.length === 0 || selectedSubcategories.length === subcategories.length"
                                    >
                                        <img src="/assets/img/icons/bi_plus-circle-fill.png" alt="">
                                        Добавить подкатегорию
                                    </button>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-sm-10">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="show_in_rating" v-model="form.show_in_rating">
                                        <label class="form-check-label" for="show_in_rating">
                                            Отображается в рейтинге
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <h5 class="card-title">Длительность обучения</h5>

                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <input type="number" class="form-control" placeholder="количество" v-model="form.study_duration">
                                    <div v-if="arrayKeyExists('study_duration', errors)" class="invalid-feedback">{{ errors.study_duration }}</div>
                                </div>
                                <div class="col-md-8">
                                    <vue-select
                                        id="time"
                                        name="time"
                                        v-model="form.time"
                                        :options="times"
                                        :settings="{
                                                placeholder: '-- Выбрать --',
                                                language: {noResults: () => 'Ничего не найдено'}
                                            }"
                                    ></vue-select>
                                    <div v-if="arrayKeyExists('time', errors)" class="invalid-feedback">{{ errors.time }}</div>
                                </div>
                            </div>

                            <h5 class="card-title">Теги</h5>
                            <ul v-if="selectedTags.length" class="ul--tags">
                                <li v-for="(t, key) in selectedTags" :key="key">
                                    <a href="#" class="btn" @click.prevent="removeTag(t.id)">
                                        {{ t.text.toString().toLowerCase() }}
                                        <img src="/assets/img/icons/bi_minus-circle.png" alt="close" class="ms-1" width="15">
                                    </a>
                                </li>
                            </ul>
                            <div class="row mb-3">
                                <div class="col-md-12">
                                    <vue-select
                                        id="tags"
                                        name="tags"
                                        v-model="form.tags"
                                        :options="tags"
                                        :settings="{
                                            placeholder: '-- Выбрать --',
                                            language: {noResults: () => 'Ничего не найдено'}
                                        }"
                                        @select="renderSelectedTags"
                                    ></vue-select>
                                </div>
                            </div>

                            <h5 class="card-title">Стоимость</h5>

                            <div class="row mb-3">
                                <div class="col-sm-12">
                                    <input type="text" v-model="form.price" class="form-control">
                                    <div v-if="arrayKeyExists('price', errors)" class="invalid-feedback">{{ errors.price }}</div>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-sm-10">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="sale" v-model="form.sale">
                                        <label class="form-check-label" for="sale">
                                            Есть скидка
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-sm-4">
                                    <vue-select
                                        id="sale_status"
                                        name="sale_status"
                                        v-model="form.sale_status"
                                        :options="getSales"
                                        :settings="{
                                            placeholder: '-- Выбрать --',
                                            language: {noResults: () => 'Ничего не найдено'}
                                        }"
                                    ></vue-select>
                                </div>
                                <div class="col-sm-8">
                                    <input type="text" v-model="form.sale_price" class="form-control">
                                    <div v-if="arrayKeyExists('sale_price', errors)" class="invalid-feedback">{{ errors.sale_price }}</div>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-sm-10">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="credit" v-model="form.credit">
                                        <label class="form-check-label" for="credit">
                                            Есть рассрочка
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-sm-6">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <label for="credit_month_price" class="form-label">Сумма ежемесячного платежа</label>
                                            <input type="text" v-model="form.credit_month_price" id="credit_month_price" class="form-control">
                                            <div v-if="arrayKeyExists('credit_month_price', errors)" class="invalid-feedback">{{ errors.credit_month_price }}</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <label for="credit_month" class="form-label">Кол-во месяцев в рассрочку</label>
                                            <input type="text" v-model="form.credit_month" id="credit_month" class="form-control">
                                            <div v-if="arrayKeyExists('credit_month', errors)" class="invalid-feedback">{{ errors.credit_month }}</div>
                                        </div>
                                    </div>
                                </div>
                                <small>Чтобы применить автоматический рассчет рассрочки, оставьте поле “Сумма” пустым</small>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-12">
                                    <label for="additional_description" class="form-label">Дополнительное описание</label>
                                    <textarea class="form-control" rows="10" id="additional_description" v-model="form.additional_description"></textarea>
                                    <div v-if="arrayKeyExists('additional_description', errors)" class="invalid-feedback">{{ errors.additional_description }}</div>
                                </div>
                                <small>Отображается в рейтингах курсов</small>
                            </div>

                            <h5 class="card-title">Служебная информация</h5>

                            <div class="row mb-3" v-if="courseId">
                                <label class="col-sm-2 col-form-label">ID</label>
                                <div class="col-sm-10">
                                    <input type="text" v-model="form.id" class="form-control">
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label">Feed ID</label>
                                <div class="col-sm-10">
                                    <input type="text" v-model="form.feed_id" class="form-control">
                                    <div v-if="arrayKeyExists('feed_id', errors)" class="invalid-feedback">{{ errors.feed_id }}</div>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label">Порядковый номер в школе</label>
                                <div class="col-sm-10">
                                    <input type="text" v-model="form.sort_order_in_schools" class="form-control">
                                    <div v-if="arrayKeyExists('sort_order_in_schools', errors)" class="invalid-feedback">{{ errors.sort_order_in_schools }}</div>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label">Порядковый номер в категориях</label>
                                <div class="col-sm-10">
                                    <input type="text" v-model="form.sort_order_in_categories" class="form-control">
                                    <div v-if="arrayKeyExists('sort_order_in_categories', errors)" class="invalid-feedback">{{ errors.sort_order_in_categories }}</div>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label">ЧПУ</label>
                                <div class="col-sm-10">
                                    <input type="text" v-model="form.url" class="form-control">
                                    <div v-if="arrayKeyExists('url', errors)" class="invalid-feedback">{{ errors.url }}</div>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label">Изображение</label>
                                <div class="col-sm-10">
                                    <input type="file" style="display: none;" ref="image" @change="changeImageHandler">
                                    <button class="btn btn-outline-info" @click.prevent="$refs.image.click()">Загрузить изображение</button>
                                    <span class="img-filename ms-2" v-if="form.image">{{ form.image.name }}
                                        <img
                                            src="/assets/img/icons/bi_minus-circle.png"
                                            alt="Удалить"
                                            width="15"
                                            class="ms-1"
                                            style="cursor: pointer"
                                            @click="form.image = ''"
                                        >
                                    </span>
                                    <div v-if="arrayKeyExists('image', errors)" class="invalid-feedback">{{ errors.image }}</div>
                                </div>
                                <template v-if="image">
                                    <div class="col-sm-4 mt-4">
                                        <img :src="image" :alt="form.title" style="width: 100%; object-fit:cover">
                                    </div>
                                    <div class="col-sm-4 mt-4">
                                        <button class="btn btn-danger" @click.prevent="removeImage">Удалить изображение</button>
                                    </div>
                                </template>
                            </div>

                            <div class="text-center">
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
export default {
    name: "CourseEdit",
    mixins: [vfMixins],
    components: {
        vueSelect: Select2,
        FlashMessage
    },
    props: {
        backUrl: {
            type: String,
            required: false,
            default: ''
        },
        courseId: {
            type: [String, Number],
            required: false,
            default: null
        }
    },
    data: () => ({
        categories: [],
        schools: [],
        subcategories: [],
        selectedSubcategories: [],
        times: [],
        tags: [],
        selectedTags: [],
        image: null,
        errors: [],
        form: {
            id: '',
            title: '',
            prefix: '',
            school: '',
            url: '',
            source_link: '',
            category: '',
            sub_category: [],
            show_in_rating: false,
            study_duration: '',
            time: '',
            tags: [],
            selectedTags: [],
            price: '',
            sale: false,
            sale_status: '',
            sale_price: '',
            credit: false,
            credit_month: '',
            credit_month_price: '',
            additional_description: '',
            feed_id: '',
            sort_order_in_schools: '',
            sort_order_in_categories: '',
            image: '',
        }
    }),
    created() {
        this.getCategories();
        this.getDuration();
        this.getSchools();
        this.getTags();
        if (this.courseId) {
            this.loadCourse();
        }
    },
    computed: {
        getSales() {
            return [
                {id: 'percent', text: 'Процент'},
                {id: 'fixed', text: 'Фикс'},
            ];
        }
    },
    methods: {
        removeImage() {
            API.courseEndpoint.removeImage(this.courseId)
                .then(response => {
                    if (response.data.status) {
                        this.image = '';
                    }
                });
        },
        async loadCourse() {
            await API.courseEndpoint.getCourse(this.courseId)
                .then(response => {
                    if (response.data.status) {
                        const course = response.data.data.course;
                        this.form.id = course.id;
                        this.form.title = course.title;
                        this.form.prefix = course.prefix;
                        this.form.school = course.school.user_id;
                        this.form.source_link = course.source_link ?? '';
                        this.form.category = course.category.id ?? '';
                        if (this.form.category) {
                            this.getSubCategories(course.category);
                        }
                        this.selectedSubcategories = course.sub_categories;
                        this.form.sub_category = course.sub_categories.map(c => c.id);
                        this.form.show_in_rating = course.show_in_rating;
                        this.form.study_duration = course.study_duration;
                        this.form.time = course.study_duration_key.id;
                        this.selectedTags = course.tags;
                        this.form.price = course.price;
                        this.form.credit = course.credit;
                        this.form.credit_month = course.credit_month;
                        this.form.credit_month_price = course.credit_month_price;
                        this.form.sale = course.sale;
                        this.form.sale_status = course.sale_key;
                        this.form.sale_price = course.sale_price;
                        this.form.additional_description = course.additional_description;
                        this.form.feed_id = course.feed_id;
                        this.form.sort_order_in_categories = course.sort_order_in_categories;
                        this.form.sort_order_in_schools = course.sort_order_in_schools;
                        this.form.url = course.url;
                        this.image = course.image;
                    }
                })
        },
        async getCategories() {
            await API.courseEndpoint.getCategories()
                .then(response => {
                    this.categories = response.data.data.results;
                })
        },
        async getTags() {
            await API.courseEndpoint.getAllTags()
                .then(response => {
                    this.tags = response.data.data.results;
                })
        },
        renderSelectedTags(val) {
            if ( !(this.selectedTags.find(f => f.id === val.id)) ) {
                this.selectedTags.push({id: val.id, text: val.text});
            }
        },
        removeTag(id) {
            this.selectedTags = this.selectedTags.filter(t => t.id !== id);
        },
        async getSubCategories(val) {
            await API.courseEndpoint.getSubCategory(val.id)
                .then(response => {
                    this.subcategories = response.data.data.results;
                }).catch(errors => {
                    console.log(errors.response.data);
                    NotificationHelper.showError("Непредвиденная ошибка. Повторите попытку.");
                })
        },
        async getDuration() {
            await API.courseEndpoint.getAllDurations()
                .then(response => {
                    this.times = response.data.data.results;
                })
        },
        async getSchools() {
            await API.courseEndpoint.getAllSchools()
                .then(response => {
                    this.schools = response.data.data.results;
                })
        },
        setSubcategory(val) {
            if (null === val) {
                this.selectedSubcategories.push({
                    id: '',
                    text: ''
                })
            } else {
                this.selectedSubcategories.map(s => {
                    if (!s.id) {
                        s.id = val.id;
                        s.text = val.text;
                    } else if (s.id === val.id) {
                        s.text = val.text;
                    }
                })
            }
        },
        removeSelectedCategory(id, index) {
            this.selectedSubcategories = this.selectedSubcategories.filter(c => c.id !== id);
            this.form.sub_category.splice(index, 1);
        },
        changeImageHandler(e) {
            this.form.image = e.target.files[0];
        },
        async formHandler() {
            if (this.courseId) {
                this.form.id = this.courseId;
            }
            if (this.selectedTags.length) {
                this.selectedTags.map(f => {
                    this.form.selectedTags.push(f.id);
                });
            }

            const fd = new FormData();

            for (const i in this.form) {
                if (i !== 'image') {
                    fd.append(i, this.form[i]);
                } else {
                    fd.append('image', this.form.image);
                }
            }
            await API.courseEndpoint.save(fd)
                .then(response => {
                    if (response.data.status) {
                        window.location.href = this.backUrl;
                    }
                }).catch(errors => {
                    this.errors = this.errorsAnswerHandling(errors);
                    console.log(this.errors)
                    NotificationHelper.showError('При заполнении формы возникои ошибки!');
                    this.$refs.formHandlerRefs.scrollIntoView();
                })
        }
    }
}
</script>

<style scoped lang="scss">
.ul--tags{
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
.invalid-feedback{
    display: block !important;
}
</style>
