<template>
    <section class="section" ref="formHandlerRefs">
        <span><a :href="listUrl" class="btn">&lt; назад</a></span>
        <div class="row">
            <div class="col-12">

                <div class="card">
                    <div class="card-body">
                        <form class="mt-2" @submit.prevent="schoolFormHandler">
                            <fieldset>
                                <legend v-if="schoolId">Редактировать школу</legend>
                                <legend v-else>Добавить школу</legend>
                                <div class="row mb-3">
                                    <label for="id" class="col-sm-2 col-form-label">ID</label>
                                    <div class="col-sm-10">
                                        <input
                                            type="text"
                                            class="form-control"
                                            id="id"
                                            :value="schoolId"
                                            readonly
                                            disabled
                                        >
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="short_title" class="col-sm-2 col-form-label">Короткое название</label>
                                    <div class="col-sm-10">
                                        <input type="text" :class="arrayKeyExists('short_title', errors) ? 'form-control is-invalid' : 'form-control'" id="short_title" v-model="form.short_title">
                                        <small v-if="arrayKeyExists('short_title', errors)">{{ errors.short_title }}</small>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="name" class="col-sm-2 col-form-label">Полное название</label>
                                    <div class="col-sm-10">
                                        <input type="text" :class="arrayKeyExists('name', errors) ? 'form-control is-invalid' : 'form-control'" id="name" v-model="form.name">
                                        <div v-if="arrayKeyExists('name', errors)" class="invalid-feedback">{{ errors.name }}</div>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="description" class="col-sm-2 col-form-label">Описание школы</label>
                                    <div class="col-sm-10">
                                        <textarea :class="arrayKeyExists('description', errors) ? 'form-control is-invalid' : 'form-control'" id="description" v-model="form.description"></textarea>
                                        <div v-if="arrayKeyExists('description', errors)" class="invalid-feedback">{{ errors.description }}</div>
                                    </div>
                                </div>
                            </fieldset>
                            <fieldset>
                                <legend>Контактные данные</legend>
                                <div class="row mb-3">
                                    <label for="phone" class="col-sm-2 col-form-label">Телефон</label>
                                    <div class="col-sm-10">
                                        <input
                                            type="text"
                                            :class="arrayKeyExists('phone', errors) ? 'form-control is-invalid' : 'form-control'"
                                            id="phone"
                                            v-model="form.phone"
                                        >
                                        <div v-if="arrayKeyExists('phone', errors)" class="invalid-feedback">{{ errors.phone }}</div>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label for="email" class="col-sm-2 col-form-label">Email</label>
                                    <div class="col-sm-10">
                                        <input type="text" :class="arrayKeyExists('email', errors) ? 'form-control is-invalid' : 'form-control'" id="email" v-model="form.email">
                                        <div v-if="arrayKeyExists('email', errors)" class="invalid-feedback">{{ errors.email }}</div>
                                    </div>
                                </div>
                            </fieldset>
                            <fieldset class="row mb-3">
                                <legend>Логотип</legend>
                                <span class="logotype-span col-sm-5">
                                    Логотип на прозрачном или белом фоне. <br>
                                    Изображение будет помещаться в контейнер размером 140 х 30 px <br>
                                    Рекомендуем использовать файлы .jpg, .svg или .png не более 200 KB.
                                </span>
                                <span v-if="form.file" class="col-sm-5">
                                    <a href="" @click.prevent="removeTmpImage"><img src="/assets/img/icons/bi_minus-circle.png" alt=""></a>
                                    {{ form.file.name }}
                                </span>
                                <span v-else-if="form?.image" class="img-logo col-sm-5">
                                    <button class="btn btn-danger" @click.prevent="removeLogo">Удалить</button>
                                    <img :src="form.image" :alt="form.name" class="logo" width="100">
                                </span>
                                <div v-if="arrayKeyExists('file', errors)" class="invalid-feedback">{{ errors.file }}</div>
                                <input type="file" name="file" style="display: none" ref="file" @change="uploadImage">
                                <div class="add">
                                    <img src="/assets/img/icons/bi_plus-circle.png" alt="">
                                    <a href="" class="btn" @click.prevent="$refs.file.click()"><template v-if="schoolId">Редактировать</template><template v-else>Добавить</template></a>
                                </div>
                            </fieldset>
                            <fieldset class="row mb-3">
                                <legend>Пароль</legend>
                                <div class="col-sm-12">
                                    <input type="password" :class="arrayKeyExists('password', errors) ? 'form-control is-invalid' : 'form-control'" id="password" v-model="form.password">
                                    <div v-if="arrayKeyExists('password', errors)" class="invalid-feedback">{{ errors.password }}</div>
                                </div>
                            </fieldset>

                            <fieldset>
                                <legend>Служебная информация</legend>

                                <div class="row mb-3">
                                    <label for="sort_order" class="col-sm-2 col-form-label">Порядковый номер в списке школ</label>
                                    <div class="col-sm-10">
                                        <input type="text" :class="arrayKeyExists('sort_order', errors) ? 'form-control is-invalid' : 'form-control'" id="sort_order" v-model="form.sort_order">
                                        <div v-if="arrayKeyExists('sort_order', errors)" class="invalid-feedback">{{ errors.sort_order }}</div>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label for="meta_title" class="col-sm-2 col-form-label">meta-tag Title</label>
                                    <div class="col-sm-10">
                                        <input type="text" :class="arrayKeyExists('meta_title', errors) ? 'form-control is-invalid' : 'form-control'" id="meta_title" v-model="form.meta_title">
                                        <div v-if="arrayKeyExists('meta_title', errors)" class="invalid-feedback">{{ errors.meta_title }}</div>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label for="meta_description" class="col-sm-2 col-form-label">meta-tag Description</label>
                                    <div class="col-sm-10">
                                        <input type="text" :class="arrayKeyExists('meta_description', errors) ? 'form-control is-invalid' : 'form-control'" id="meta_description" v-model="form.meta_description">
                                        <div v-if="arrayKeyExists('meta_description', errors)" class="invalid-feedback">{{ errors.meta_description }}</div>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label for="url" class="col-sm-2 col-form-label">ЧПУ</label>
                                    <div class="col-sm-10">
                                        <input type="text" :class="arrayKeyExists('url', errors) ? 'form-control is-invalid' : 'form-control'" id="url" v-model="form.url">
                                        <div v-if="arrayKeyExists('url', errors)" class="invalid-feedback">{{ errors.url }}</div>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label for="site_link_text" class="col-sm-2 col-form-label">Отображаемая ссылка</label>
                                    <div class="col-sm-10">
                                        <input type="text" :class="arrayKeyExists('site_link_text', errors) ? 'form-control is-invalid' : 'form-control'" id="site_link_text" v-model="form.site_link_text">
                                        <div v-if="arrayKeyExists('site_link_text', errors)" class="invalid-feedback">{{ errors.site_link_text }}</div>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label for="site_link" class="col-sm-2 col-form-label">Полная ссылка на сайт</label>
                                    <div class="col-sm-10">
                                        <input type="text" :class="arrayKeyExists('site_link', errors) ? 'form-control is-invalid' : 'form-control'" id="site_link" v-model="form.site_link">
                                        <div v-if="arrayKeyExists('site_link', errors)" class="invalid-feedback">{{ errors.site_link }}</div>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label for="meta_point" class="col-sm-2 col-form-label">Метка для ссылки</label>
                                    <div class="col-sm-10">
                                        <input type="text" :class="arrayKeyExists('meta_point', errors) ? 'form-control is-invalid' : 'form-control'" id="meta_point" v-model="form.meta_point">
                                        <small>Используйте шаблон "тег=%s" для динамического вывода меток, где слово "тег" замените на нужный вам парметр</small>
                                        <div v-if="arrayKeyExists('meta_point', errors)" class="invalid-feedback">{{ errors.meta_point }}</div>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label for="partner_suffix" class="col-sm-2 col-form-label">Префикс парнерской ссылки</label>
                                    <div class="col-sm-10">
                                        <input type="text" :class="arrayKeyExists('partner_suffix', errors) ? 'form-control is-invalid' : 'form-control'" id="partner_suffix" v-model="form.partner_suffix">
                                        <div v-if="arrayKeyExists('partner_suffix', errors)" class="invalid-feedback">{{ errors.partner_suffix }}</div>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="partner_postfix" class="col-sm-2 col-form-label">Постфикс для ссылки</label>
                                    <div class="col-sm-10">
                                        <input type="text" :class="arrayKeyExists('partner_postfix', errors) ? 'form-control is-invalid': 'form-control'" id="partner_postfix" v-model="form.partner_postfix">
                                        <div v-if="arrayKeyExists('partner_postfix', errors)" class="invalid-feedback">{{ errors.partner_postfix }}</div>
                                    </div>
                                </div>
                            </fieldset>

                            <div class="row mb-3">
                                <div class="col-sm-10">
                                    <button
                                        type="submit"
                                        class="btn btn-outline-primary"
                                    >
                                        <template v-if="schoolId">Редактировать школу</template>
                                        <template v-else>Добавить школу</template>
                                    </button>
                                </div>
                            </div>

                        </form><!-- End General Form Elements -->

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
import API from "../../helpers/api";
import vfMixins from "../../mixins/validation";
import FlashMessage from "../notifications/FlashMessage";
import NotificationHelper from "../../modules/notifications";

export default {
    name: "EditSchool",
    mixins: [vfMixins],
    props: {
        listUrl: {
            type: String,
            required: true
        },
        schoolId: {
            type: [String, Number],
            required: false,
            default: null
        }
    },
    components: {
        FlashMessage
    },
    data: () => ({
        errors: [],
        form: {
            id: '',
            short_title: '',
            name: '',
            description: '',
            phone: '',
            email: '',
            file: '',
            password: '',
            sort_order: '',
            meta_title: '',
            meta_description: '',
            url: '',
            site_link_text: '',
            site_link: '',
            meta_point: '',
            partner_suffix: '',
            partner_postfix: '',
        }
    }),
    watch: {
        form: {
            deep: true,
            handler(data) {
                const {name, description, phone, email, password, url, sort_order} = data;

                if (this.arrayKeyExists('name', this.errors) && name.length > 3) {
                    delete this.errors.name;
                }

                if (this.arrayKeyExists('description', this.errors) && description.length > 10) {
                    delete this.errors.description;
                }

                if (this.arrayKeyExists('phone', this.errors) && phone.length) {
                    delete this.errors.phone;
                }

                if (this.arrayKeyExists('email', this.errors) && this.validateEmail(email)) {
                    delete this.errors.email;
                }

                if (this.arrayKeyExists('password', this.errors) && password.length >= 6) {
                    delete this.errors.password;
                }

                if (this.arrayKeyExists('url', this.errors) && url.length) {
                    delete this.errors.url;
                }

                if (this.arrayKeyExists('sort_order', this.errors) && sort_order.length) {
                    delete this.errors.sort_order;
                }
            }
        }
    },
    created() {
        this.loadSchoolById();
    },
    methods: {
        uploadImage(e) {
            this.form.file = e.target.files[0]
        },
        removeTmpImage() {
            this.form.file = '';
        },
        async removeLogo() {
              await API.schoolsEndpoint.removeLogo(this.schoolId)
                .then(response => {
                    if (response.data.status) {
                        this.form.file = '';
                        delete this.form.image;
                    }
                })
        },
        async schoolFormHandler() {
            this.form.id = this.schoolId ?? '';
            const fd = new FormData();
            for (const i in this.form) {
                fd.append(i, this.form[i])
            }
            await API.schoolsEndpoint.saveSchool(fd)
                .then(response => {
                    if (response.data.status) {
                        window.location.href = '/schools';
                    } else {
                        NotificationHelper.showError(response.data.data.message);
                    }
                })
                .catch(errors => {
                    this.errors = this.errorsAnswerHandling(errors);
                    NotificationHelper.showError('При заполнении формы возникои ошибки!');
                    this.$refs.formHandlerRefs.scrollIntoView();
                })
        },
        async loadSchoolById() {
            if (this.schoolId) {
                await API.schoolsEndpoint.getSchool(this.schoolId)
                    .then(response => {
                        this.form = response.data.data.result;
                    })
            }
        }
    }
}
</script>

<style scoped lang="scss">
.logotype-span{
    font-weight: 300;
    line-height: 20px;
    font-size: 16px;
    color: #000;
}
img{
    &.logo{
        object-fit: cover;
        max-width: 200px;
    }
}
.img-logo{
    position: relative;
    & .btn{
        position: absolute;
        top: 0;
        right: -1rem;
    }
}
</style>
