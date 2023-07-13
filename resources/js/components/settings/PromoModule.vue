<template>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Управление модулем Промокоды</h5>

                    <!-- Horizontal Form -->
                    <form @submit.prevent="save">
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label">Promo code</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" v-model="form.promo">
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

                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label">Школы</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" v-model="search" @input="searchHandler">
                                <ul :class="searchResults.length ? 'dropdown-menu active' : 'dropdown-menu'" v-if="searchResults.length">
                                    <li v-for="school in searchResults" :key="`school-result${school.id}`">
                                        <a href="#" @click.prevent="setSchool(school)">{{ school.name }}</a>
                                    </li>
                                </ul>
                                <div class="well well-sm" style="height: 150px; overflow: auto;">
                                    <template v-if="form.schools">
                                        <div v-for="s in form.schools" :id="`promo-school${s.id}`" :key="`s-${s.id}`">
                                            <i class="bi bi-file-minus-fill" @click.prevent="removeSchool(s.id)"></i>
                                            {{ s.name }}
                                        </div>
                                    </template>
                                </div>
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
import debounce from "../../modules/debounser";
export default {
    name: "PromoModule",
    data: () => ({
        loading: false,
        search: '',
        searchResults: [],
        form: {
            title: '',
            description: '',
            promo: '',
            schools: []

        }
    }),
    created() {
        this.getPromo();
    },
    methods: {
        async save() {
            this.loading = true;
            await API.optionsEndpoint.savePromoModule(this.form)
                .finally(() => {
                    setTimeout(() => {
                        this.loading = false;
                    }, 1000)
                })
        },
        async searchHandler() {
            if (this.search) {
                await this.getSchools(this);
            }
        },
        getSchools: debounce(async (self) => {
            const ids = [];

            if (self.form.schools) {
                self.form.schools.map(s => {
                    ids.push(s.id);
                });
            }
            return await API.optionsEndpoint.getSchoolsByName(self.search, ids)
                .then(response => {
                    if (response.data.status) {
                        self.searchResults = response.data.data.results;
                    }
                })
        }, 300),
        async getPromo() {
            await API.optionsEndpoint.getPromoModule()
                .then(response => {
                    const res = response.data.data.result;
                    if (res) {
                        this.form.promo = res.promo;
                        this.form.title = res.title;
                        this.form.description = res.description;
                        this.form.schools = res.schools;
                    }
                });
        },
        removeSchool(id) {
            this.form.schools = this.form.schools.filter(s => s.id !== id);
        },
        setSchool(school) {
            if (!this.form.schools) {
                this.form.schools = [];
            }
            this.form.schools.push({id: school.id, name: school.name});
            this.search = '';
            this.searchResults = [];
        }
    }
}
</script>

<style scoped>
    .well {
        padding: 9px;
        border-radius: 2px;
        min-height: 20px;
        margin-bottom: 20px;
        background-color: #f5f5f5;
        border: 1px solid #e3e3e3;
        -webkit-box-shadow: inset 0 1px 1px rgba(0, 0, 0, .05);
        box-shadow: inset 0 1px 1px rgba(0, 0, 0, .05);
    }
    .dropdown-menu.active{
        display: block;
        padding: 10px;
        margin: 0;
        width: 80%;
    }

    .dropdown-menu.active li{
        margin-bottom: 0.6rem;
    }

    .dropdown-menu.active li a{
        color: #000;
    }
    .bi-file-minus-fill{
        cursor: pointer;
        margin-right: 0.5rem;
    }
</style>
