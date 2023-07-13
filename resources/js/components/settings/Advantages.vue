<template>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Управление модулем преимуществ</h5>
                    <table class="table table-bordered">
                        <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Заголовок</th>
                            <th scope="col">Сортировка</th>
                            <th scope="col">Описание</th>
                            <th scope="col" style="width: 200px">Действия</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-for="(a,k) in advantages" :key="k">
                            <th scope="row">{{ a.id }}</th>
                            <td>{{ a.title }}</td>
                            <td>{{ a.sort_order }}</td>
                            <td>{{ a.description }}</td>
                            <td style="width: 200px">
                                <div>
                                    <button class="btn btn-outline-info me-2" @click.prevent="showEditPopup(a)"><i class="bi bi-pencil-fill"></i></button>
                                    <button class="btn btn-danger" @click.prevent="removeOption(a)"><i class="bi bi-trash-fill"></i></button>
                                </div>
                            </td>
                        </tr>
                            <tr>
                                <td colspan="5" style="">
                                    <button class="btn btn-outline-success" @click.prevent="showPopup"><i class="bi bi-plus-circle-fill"></i></button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="modal fade" id="fullscreenModal" tabindex="-1" aria-hidden="true" ref="fullscreenModal">
            <div class="modal-dialog modal-fullscreen">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Редактировать блок</h5>
                        <button type="button" class="btn-close" @click.prevent="closeModal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label">Заголовок</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" v-model="form.title">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label">Сортировка</label>
                            <div class="col-sm-10">
                                <input type="number" class="form-control" v-model="form.sort_order">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label">Описание</label>
                            <div class="col-sm-10">
                                <textarea class="form-control" style="width: 100%" rows="20" v-model="form.description"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" @click.prevent="closeModal">Закрыть</button>
                        <button type="button" class="btn btn-primary" @click.prevent="save">Сохранить</button>
                    </div>
                </div>
            </div>
        </div>

    </div>
</template>

<script>
import API from "../../helpers/api";

export default {
    name: "Advantages",
    data: () => ({
        advantages: [],
        edit: false,
        form: {
            id: '',
            title: '',
            description: '',
            sort_order: 0,
        }
    }),
    created() {
        this.getOptions();
    },
    computed: {
        popupModal() {
            return new bootstrap.Modal(this.$refs.fullscreenModal);
        }
    },
    methods: {
        showPopup() {
            this.popupModal.show();
        },
        showEditPopup(advantage) {
            this.edit = true;
            this.form.id = advantage.id;
            this.form.title = advantage.title;
            this.form.sort_order = advantage.sort_order;
            this.form.description = advantage.description;
            this.popupModal.show();
        },
        closeModal() {
            this.resetForm();
            this.popupModal.hide()
        },
        resetForm() {
            this.edit = false;
            this.form.id = '';
            this.form.title = '';
            this.form.description = '';
            this.form.sort_order = 0;
        },
        async save() {
            if (this.edit) {
                await API.optionsEndpoint.editAdvantages({
                    title: this.form.title,
                    description: this.form.description,
                    sort_order: this.form.sort_order
                }, this.form.id)
                    .then(response => {
                        if (response.data.status) {
                            this.getOptions();
                        }
                    }).catch(errors => {
                        // todo: можно сделать на фронтенде покрасивее вывод ошибок
                        alert(errors?.response?.data?.errors.message)
                    }).finally(() => {
                        this.resetForm();
                        this.popupModal.hide();
                    })
            } else {
                await API.optionsEndpoint.saveAdvantages(this.form)
                    .then(response => {
                        if (response.data.status) {
                            this.getOptions();
                        }
                    }).catch(errors => {
                        // todo: можно сделать на фронтенде покрасивее вывод ошибок
                        alert(errors?.response?.data?.errors.message)
                    }).finally(() => {
                        this.resetForm();
                        this.popupModal.hide();
                    })
            }
        },
        async getOptions() {
            await API.optionsEndpoint.getAdvantages()
                .then(response => {
                    if (response.data.status) {
                        this.advantages = response.data.data.results;
                    }
                })
        },
        async removeOption(advantage) {
            await API.optionsEndpoint.removeAdvantage(advantage.id)
                .finally(() => {
                    this.resetForm();
                    this.getOptions();
                }).catch(errors => {
                    // todo: можно сделать на фронтенде покрасивее вывод ошибок
                    alert(errors?.response?.data?.errors.message)
                })
        }
    }
}
</script>

<style scoped>

</style>
