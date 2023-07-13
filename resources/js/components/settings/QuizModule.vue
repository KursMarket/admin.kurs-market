<template>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Управление модулем Quiz</h5>

                    <!-- Horizontal Form -->
                    <form @submit.prevent="save">
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label">Ссылка на тест</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" v-model="form.quiz_link">
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label">Заголовок</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" v-model="form.title">
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label">Описание</label>
                            <div class="col-sm-10">
                                <textarea type="text" class="form-control" v-model="form.description" rows="6"></textarea>
                            </div>
                        </div>

                        <div class="text-center">
                            <a href="#" @click.prevent="" class="btn btn-primary" v-if="loading" style="color: #fff;">Сохранение...</a>
                            <button type="submit" class="btn btn-primary" v-else>Сохранить</button>
                        </div>
                    </form><!-- End Horizontal Form -->

                </div>
            </div>
        </div>
    </div>
</template>

<script>
import API from "../../helpers/api";

export default {
    name: "QuizModule",
    data: () => ({
        loading: false,
        form: {
            quiz_link: '',
            title: '',
            description: ''
        }
    }),
    created() {
        this.getQuiz();
    },
    methods: {
        async save() {
            this.loading = true;
            await API.optionsEndpoint.saveQuiz(this.form)
              .catch(errors => {
                    // todo: можно сделать на фронтенде покрасивее вывод ошибок
                    alert(errors?.response?.data?.errors.message)
                }).finally(() => {
                    setTimeout(() => {
                        this.loading = false;
                    }, 1000)
                })
        },
        async getQuiz() {
            await API.optionsEndpoint.getQuiz()
                .then(response => {
                    const r = response.data.data.result;

                    this.form.quiz_link = r?.quiz_link;
                    this.form.title = r?.title;
                    this.form.description = r?.description;
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
