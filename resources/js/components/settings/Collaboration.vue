<template>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Управление модулем Сотрудничества</h5>
                    <form @submit.prevent="save">
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
                                    <template v-if="schools">
                                        <div v-for="s in schools" :id="`promo-school${s.id}`" :key="`s-${s.id}`">
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
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import API from "../../helpers/api";
import debounce from "../../modules/debounser";
export default {
    name: "Collaboration",
    data: () => ({
        loading: false,
        search: '',
        searchResults: [],
        schools: []
    }),
    created() {
        this.getCollaborationModule();
    },
    methods: {
        async getCollaborationModule() {
            await API.optionsEndpoint.getCollaborationModule()
                .then(response => {
                    this.schools = response.data.data.result;
                });
        },
        async save() {
            this.loading = true;
            await API.optionsEndpoint.saveCollaboration(this.schools)
                .finally(() => {
                    setTimeout(() => {
                        this.loading = false;
                    }, 1000)
                });
        },
        async searchHandler() {
            if (this.search) {
                await this.getSchools(this);
            }
        },
        getSchools: debounce(async (self) => {
            const ids = [];

            if (self.schools) {
                self.schools.map(s => {
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
        setSchool(school) {
            if (!this.schools) {
                this.schools = [];
            }
            this.schools.push({id: school.id, name: school.name});
            this.search = '';
            this.searchResults = [];
        },
        removeSchool(id) {
            this.schools = this.schools.filter(s => s.id !== id);
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
