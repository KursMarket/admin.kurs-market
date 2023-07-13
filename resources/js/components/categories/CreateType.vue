<template>
    <section class="section" ref="formHandlerRefs">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <form :class="loading ? 'mt-4 loading' : 'mt-4'" @submit.prevent="save">
                            <div class="row mb-3">
                                <label for="title" class="col-sm-2 col-form-label">Название</label>
                                <div class="col-sm-10">
                                    <input
                                        type="text"
                                        :class="arrayKeyExists('title', errors) ? 'form-control is-invalid' : 'form-control'"
                                        id="title"
                                        v-model="form.title"
                                    >
                                    <div v-if="arrayKeyExists('title', errors)" class="invalid-feedback">{{ errors.title }}</div>
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
                            <div class="row mb-3">
                                <label for="sortOrder" class="col-sm-2 col-form-label">Порядок сортировки</label>
                                <div class="col-sm-10">
                                    <input
                                        type="text"
                                        :class="arrayKeyExists('sort_order', errors) ? 'form-control is-invalid' : 'form-control'"
                                        id="sortOrder"
                                        v-model="form.sort_order"
                                    >
                                    <div v-if="arrayKeyExists('sort_order', errors)" class="invalid-feedback">{{ errors.sort_order }}</div>
                                </div>
                            </div>
                            <div class="text-center">
                                <button type="submit" class="btn btn-primary">Сохранить</button>
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
import API from "../../helpers/api";
import NotificationHelper from "../../modules/notifications";
import vfMixins from "../../mixins/validation";
import FlashMessage from "../notifications/FlashMessage";

export default {
    name: "CreateType",
    mixins: [vfMixins],
    components: {
        FlashMessage
    },
    data: () => ({
        loading: false,
        errors: [],
        form: {
            title: '',
            url: '',
            sort_order: ''
        }
    }),
    methods: {
        async save() {
            API.categoryEndpoint.saveCatalogType(this.form)
            .then(response => {
                if (response.data.status) {
                    window.location.href = '/types';
                }
            }).catch(errors => {
                this.errors = this.errorsAnswerHandling(errors);
                console.log(this.errors)
                NotificationHelper.showError('При заполнении формы возникои ошибки!');
                this.$refs.formHandlerRefs.scrollIntoView();
            }).finally(() => {
                this.loading = false;
            })
        }
    }
}
</script>

<style scoped lang="scss">
    .invalid-feedback{
        display: block;
    }
</style>
