<template>
    <section :class="loading ? 'section loading' : 'section'" ref="formHandlerRefs">
        <span><a :href="listRoute" class="btn">&lt; назад</a></span>
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <form class="mt-2" @submit.prevent="save">
                            <fieldset>
                                <legend v-if="categoryId">Редактировать категорию</legend>
                                <legend v-else>Добавить категорию</legend>
                                <div class="row mb-3" v-if="categoryId">
                                    <label for="id" class="col-sm-2 col-form-label">ID</label>
                                    <div class="col-sm-10">
                                        <input
                                            type="text"
                                            class="form-control"
                                            id="id"
                                            :value="categoryId"
                                            readonly
                                            disabled
                                        >
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="title" class="col-sm-2 col-form-label">Название категории</label>
                                    <div class="col-sm-10">
                                        <input
                                            type="text"
                                            @blur="makeUrlFromTitle"
                                            :class="arrayKeyExists('title', errors) ? 'form-control is-invalid' : 'form-control'"
                                            id="title" v-model="form.title">
                                        <small class="invalid-feedback" v-if="arrayKeyExists('title', errors)">{{ errors.title }}</small>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="meta_h1" class="col-sm-2 col-form-label">Доп. название Заголовок H1</label>
                                    <div class="col-sm-10">
                                        <input
                                            type="text"
                                            :class="arrayKeyExists('meta_h1', errors) ? 'form-control is-invalid' : 'form-control'"
                                            id="meta_h1"
                                            v-model="form.meta_h1"
                                        >
                                        <div v-if="arrayKeyExists('meta_h1', errors)" class="invalid-feedback">{{ errors.meta_h1 }}</div>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="sort_order" class="col-sm-2 col-form-label">Порядковый номер в списке категорий</label>
                                    <div class="col-sm-10">
                                        <input
                                            type="text"
                                            :class="arrayKeyExists('sort_order', errors) ? 'form-control is-invalid' : 'form-control'"
                                            id="sort_order"
                                            v-model="form.sort_order"
                                        >
                                        <div v-if="arrayKeyExists('sort_order', errors)" class="invalid-feedback">{{ errors.sort_order }}</div>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="sort_order" class="col-sm-2 col-form-label">Тип каталога</label>
                                    <div class="col-sm-10">
                                        <select v-model="form.type_id" id="type_id" class="form-select">
                                            <option value="">-- Выбрать --</option>
                                            <option
                                                :value="type.id"
                                                v-for="type in types"
                                                :key="`option-type-${type.id}`"
                                            >{{type.title}}</option>
                                        </select>
                                        <div v-if="arrayKeyExists('type_id', errors)" class="invalid-feedback">{{ errors.type_id }}</div>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="parent_id" class="col-sm-2 col-form-label">Родительская категория (для подкатегорий)</label>
                                    <div class="col-sm-10">
                                        <select v-model="form.parent_id" id="parent_id" class="form-select">
                                            <option value="">-- Выбрать --</option>
                                            <option
                                                :value="cat.id"
                                                v-for="cat in categoriesSelect"
                                                :key="`option-${cat.id}`"
                                            >{{cat.title}}</option>
                                        </select>
                                        <div v-if="arrayKeyExists('parent_id', errors)" class="invalid-feedback">{{ errors.parent_id }}</div>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="offset-sm-2 col-sm-10">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="show_in_catalog" v-model="form.show_in_catalog">
                                            <label class="form-check-label" for="show_in_catalog">
                                                Отображать в каталоге
                                            </label>
                                        </div>

                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="show_in_rating" v-model="form.show_in_rating">
                                            <label class="form-check-label" for="show_in_rating">
                                                Отображать в рейтинге
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-12">
                                        <h4>Похожие категории</h4>
                                    </div>
                                    <div class="related-cats" v-if="related.length">
                                        <ul>
                                            <li
                                                v-for="c in related"
                                                :key="`related-${c.id}`"
                                                class="alert alert-success"
                                            ><a href="#" class="btn btn-danger me-4" @click.prevent="rmRelated(c.id)">Удалить</a>{{ c.title }}</li>
                                        </ul>
                                    </div>
                                    <label for="related_category" class="col-sm-2 col-form-label">Категория</label>
                                    <div class="col-sm-10">
                                        <select name="related_category" id="related_category" class="form-select" v-model="form.related_category_id" @change="setRelated">
                                            <option value="">-- Выбрать --</option>
                                            <option
                                                :value="cat.id"
                                                v-for="cat in categoriesSelect"
                                                :key="`option-related-category-${cat.id}`"
                                            >{{cat.title}}</option>
                                        </select>
                                    </div>
                                    <sub-category-select
                                        v-for="c in categories"
                                        :parent-category-id="relatedParentCategory"
                                        :index="c.index"
                                    ></sub-category-select>
                                    <div class="actions col-4 offset-8">
                                        <button
                                            class="btn mt-2"
                                            @click.prevent="addCategoryToStore"
                                            :disabled="relatedParentCategory === 0"
                                        >
                                            <img src="/assets/img/icons/bi_plus-circle-fill.png" alt="" class="me-2">Добавить подкатегорию
                                        </button>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="meta_title" class="col-sm-2 col-form-label">meta-tag Title</label>
                                    <div class="col-sm-10">
                                        <input
                                            type="text"
                                            :class="arrayKeyExists('meta_title', errors) ? 'form-control is-invalid' : 'form-control'"
                                            id="meta_title"
                                            v-model="form.meta_title"
                                        >
                                        <div v-if="arrayKeyExists('meta_title', errors)" class="invalid-feedback">{{ errors.meta_title }}</div>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="meta_description" class="col-sm-2 col-form-label">meta-tag Description</label>
                                    <div class="col-sm-10">
                                        <textarea
                                            :class="arrayKeyExists('meta_description', errors) ? 'form-control is-invalid' : 'form-control'"
                                            id="meta_description"
                                            rows="10"
                                            v-model="form.meta_description"
                                        ></textarea>
                                        <div v-if="arrayKeyExists('meta_description', errors)" class="invalid-feedback">{{ errors.meta_description }}</div>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="text_before_courses_list" class="col-sm-2 col-form-label">Описание до списка курсов</label>
                                    <div class="col-sm-10">
                                        <textarea
                                            :class="arrayKeyExists('text_before_courses_list', errors) ? 'form-control is-invalid' : 'form-control'"
                                            id="text_before_courses_list"
                                            rows="10"
                                            v-model="form.text_before_courses_list"
                                        ></textarea>
                                        <div v-if="arrayKeyExists('text_before_courses_list', errors)" class="invalid-feedback">{{ errors.text_before_courses_list }}</div>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="text_after_courses_list" class="col-sm-2 col-form-label">Описание после списка курсов</label>
                                    <div class="col-sm-10">
                                        <textarea
                                            :class="arrayKeyExists('text_after_courses_list', errors) ? 'form-control is-invalid' : 'form-control'"
                                            id="text_after_courses_list"
                                            rows="10"
                                            v-model="form.text_after_courses_list"
                                        ></textarea>
                                        <div v-if="arrayKeyExists('text_after_courses_list', errors)" class="invalid-feedback">{{ errors.text_after_courses_list }}</div>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="url" class="col-sm-2 col-form-label">ЧПУ</label>
                                    <div class="col-sm-10">
                                        <input
                                            type="text"
                                            :class="arrayKeyExists('url', errors) ? 'form-control is-invalid' : 'form-control'"
                                            id="url"
                                            v-model="form.url"
                                        >
                                        <div v-if="arrayKeyExists('url', errors)" class="invalid-feedback">{{ errors.url }}</div>
                                    </div>
                                </div>
                            </fieldset>

                            <div class="row mb-3">
                                <div class="col-sm-10">
                                    <button
                                        type="submit"
                                        class="btn btn-outline-primary"
                                    >
                                        <template v-if="categoryId">Редактировать категорию</template>
                                        <template v-else>Добавить категорию</template>
                                    </button>
                                    <button v-if="categoryId" class="btn btn-danger ms-2" @click.prevent="removeCategory">Удалить</button>
                                </div>
                            </div>

                        </form><!-- End General Form Elements -->

                    </div>
                </div>
            </div>
        </div>
    </section>
    <flash-message
        :duration="getDurationForFlash"
    />
</template>

<script>
import FlashMessage from "../notifications/FlashMessage";
import API from "../../helpers/api";
import vfMixins from "../../mixins/validation";
import NotificationHelper from "../../modules/notifications";
import SubCategorySelect from "./Embed/SubCategorySelect";
import {mapGetters, mapState} from 'vuex';
export default {
    name: "EditCategory",
    mixins: [vfMixins],
    components: {
        FlashMessage,
        SubCategorySelect
    },
    props: {
        categoryId: {
            type: [String, Number],
            required: false,
            default: null
        },
        listRoute: {
            type: String,
            required: true
        },
        parentCategoryId: {
            type: [String, Number],
            required: false,
            default: null
        }
    },
    computed: {
        getDurationForFlash() {
            return this.flashDuration;
        },
        ...mapGetters([
            'getStateCategories',
            'getStateCategoriesLength'
        ]),
        ...mapState([
            'categories'
        ])
    },
    data: () => ({
        relatedParentCategory: 0,
        errors: [],
        count: 1,
        loading: false,
        flashDuration: -1,
        categoriesSelect: [],
        relatedSubCategories: [],
        related: [],
        types: [],
        form: {
            id: '',
            title: '',
            meta_h1: '',
            sort_order: '',
            type_id: 0,
            parent_id: 0,
            related_category_id: 0,
            related: [],
            show_in_catalog: '',
            show_in_rating: '',
            meta_title: '',
            meta_description: '',
            text_before_courses_list: '',
            text_after_courses_list: '',
            url: '',
        }
    }),
    created() {
        this.getCategories();
        this.getCatalogTypes();
        if (this.parentCategoryId) {
            this.form.parent_id = +this.parentCategoryId;
        }
        if (this.categoryId) {
            this.getCategory();
        }
    },
    methods: {
        async rmRelated(id) {
            await API.categoryEndpoint.rmRelated(this.categoryId, id)
                .then(() => {
                    this.related = this.related.filter(r => r.id !== id);
                })
        },
        addCategoryToStore() {
            this
                .$store
                .dispatch('saveCategory', {index: this.getStateCategoriesLength + 1, id: null });
        },
        setRelated() {
            this.relatedParentCategory = this.form.related_category_id;
        },
        setRelatedChildren(data) {
            this.related.forEach((r, i) => {
                if (r.index === data.index) {
                    this.related.splice(i, 1)
                }
            })
            this.related.push(data);
        },
        removeRelatedSubcategory(index) {
            this.related = this.related.filter(r => r.index !== index);
            this.count--;
        },
        makeUrlFromTitle() {
            this.flashDuration = -1;
            API.categoryEndpoint.makeUrlFromTitle(this.form.title, this.form.id)
            .then(response => {
                if (response.data.status) {
                    this.form.url = response.data.data.result;
                    delete this.errors.url;
                }
            }).catch((errors) => {
                NotificationHelper.showError(errors.response.data.errors.message);
            })
        },
        async getCategories() {
            await API.categoryEndpoint.getAllCategoriesForSelect()
                .then(response => {
                    if (response.data.status) {
                        this.categoriesSelect = response.data.data.results;
                    }
                })
        },
        async getCategory() {
            await API.categoryEndpoint.getCategoryById(this.categoryId)
                .then(response => {
                    const cat = response.data.data.result;
                    this.form.id = cat.id;
                    this.form.title = cat.title;
                    this.form.meta_h1 = cat.meta_h1;
                    this.form.sort_order = cat.sort_order;
                    this.form.type_id = cat.type?.id;
                    this.form.parent_id = cat.parent?.id;
                    this.form.show_in_catalog = cat.show_in_catalog;
                    this.form.show_in_rating = cat.show_in_rating;
                    this.form.meta_title = cat.meta_title;
                    this.form.meta_description = cat.meta_description;
                    this.form.text_before_courses_list = cat.text_before_courses_list;
                    this.form.text_after_courses_list = cat.text_after_courses_list;
                    this.form.url = cat.url;
                    if (cat.relatedCategories.length) {
                        cat.relatedCategories.map(c => {
                            this.related.push(c);
                        });
                    }
                })
        },
        async save() {
            this.flashDuration = 3000;
            this.loading = true;
            if (this.form.parent_id === 0) {
                this.form.parent_id = '';
            }
            this.form.related = [];
            this.categories.map(r => {
                if (null !== r.id) {
                    this.form.related.push(r.id);
                }
            })
            await API.categoryEndpoint.saveCategory(this.form)
            .then(response => {
                if (response.data.status) {
                    window.location.href = this.listRoute
                }
            }).catch((errors) => {
                    this.errors = this.errorsAnswerHandling(errors);
                    NotificationHelper.showError('При заполнении формы возникои ошибки!');
                    this.$refs.formHandlerRefs.scrollIntoView();
            })
            .finally(() => {
                this.loading = false;
            })
        },
        async removeCategory() {
            if (confirm('Вы уверены? Это действие необратимо!')) {
                await API.categoryEndpoint.removeCategory(this.categoryId)
                    .then(response => {
                        if (response.data.status) {
                            window.location.href = this.listRoute;
                        }
                    }).catch(errors => {
                        this.$refs.formHandlerRefs.scrollIntoView();
                        NotificationHelper.showError(errors.response.data.errors.message);
                    })
            }
        },
        async getCatalogTypes() {
            await API.categoryEndpoint.getAllTypes()
            .then(response => {
                this.types = response.data.data.results;
            })
        }
    }
}
</script>

<style scoped lang="scss">
section{
    &.loading{
        opacity: .5;
        pointer-events: none;
    }
}
.related-cats{
    & ul {
        margin: 0;
        padding: 0;
        li {
            list-style-type: none;
        }
    }
}
</style>
