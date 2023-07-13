<template>
    <section class="section">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Добавить длительность</h5>

                        <!-- General Form Elements -->
                        <form @submit.prevent="save" :class="loading ? 'loading' : ''">
                            <div class="row mb-3" v-if="form.id">
                                <label for="ID" class="col-sm-2 col-form-label">ID</label>
                                <div class="col-sm-10">
                                    <input type="text" id="ID" class="form-control" :value="form.id" readonly disabled>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="title" class="col-sm-2 col-form-label">Заголовок</label>
                                <div class="col-sm-10">
                                    <input type="text" id="title" class="form-control" v-model="form.title">
                                    <div v-if="arrayKeyExists('title', errors)" class="invalid-feedback" style="display: block;">{{ errors.title }}</div>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="alias" class="col-sm-2 col-form-label">Алиас</label>
                                <div class="col-sm-10">
                                    <input type="text" id="alias" class="form-control" v-model="form.alias">
                                    <div v-if="arrayKeyExists('alias', errors)" class="invalid-feedback" style="display: block;">{{ errors.alias }}</div>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="sort_order" class="col-sm-2 col-form-label">Сортировка</label>
                                <div class="col-sm-10">
                                    <input type="text" id="sort_order" class="form-control" v-model="form.sort_order">
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-sm-10">
                                    <button type="submit" class="btn btn-primary">Сохранить</button>
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
    ></flash-message>
</template>

<script>
import API from "../../helpers/api";
import NotificationHelper from "../../modules/notifications";
import FlashMessage from "../notifications/FlashMessage";
import vfMixins from "../../mixins/validation";
export default {
    name: "DurationSave",
    mixins: [vfMixins],
    components: {
        FlashMessage
    },
    props: {
        durationId: {
            type: [String, Number],
            required: false,
            default: null
        }
    },
    data: () => ({
        loading: false,
        errors: [],
        form: {
            id: '',
            title: '',
            alias: '',
            sort_order: 0
        }
    }),
    created() {
        if (null !== this.durationId) {
            this.getById();
        }
    },
    methods: {
        async save() {
            this.loading = true;
            await API.durationEndpoint.save(this.form)
                .then(response => {
                    if (response.data.status) {
                        window.location.href = '/durations'
                    }
                }).catch(errors => {
                    this.errors = this.errorsAnswerHandling(errors);
                }).finally(() => {
                    this.loading = false;
                })
        },
        async getById() {
            this.loading = true;
            await API.durationEndpoint.getById(this.durationId)
                .then(response => {
                    if (response.data.status) {
                        const tag = response.data.data.result;
                        this.form.id = tag.id;
                        this.form.title = tag.title;
                        this.form.alias = tag.alias;
                        this.form.sort_order = tag.sort_order;
                    }
                }).catch(() => {
                    NotificationHelper.showError('Возникли ошибки! Перезагрузите страницу и повторите попытку!')
                }).finally(() => {
                    this.loading = false;
                })
        }
    }
}
</script>

<style scoped>

</style>
