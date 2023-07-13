<template>
    <div class="row mb-3">
        <input type="hidden" name="school_id" :value="school_id">
        <label class="col-sm-2 col-form-label">Школы</label>
        <div class="col-sm-10">
            <input type="text" class="form-control" v-model="search" @input="searchHandler">
            <ul :class="searchResults.length ? 'dropdown-menu active' : 'dropdown-menu'" v-if="searchResults.length">
                <li v-for="school in searchResults" :key="`school-result${school.id}`">
                    <a href="#" @click.prevent="setCurrentSchool(school)">{{ school.name }}</a>
                </li>
            </ul>
            <div class="well well-sm" style="height: 70px; overflow: auto;">
                <template v-if="schools">
                    <div v-for="s in schools" :id="`promo-school${s.id}`" :key="`s-${s.id}`">
                        <i class="bi bi-file-minus-fill" @click.prevent="removeSchool(s.id)"></i>
                        {{ s.name }}
                    </div>
                </template>
            </div>
        </div>
    </div>
</template>

<script>
import debounce from "../../modules/debounser";
import API from "../../helpers/api";
export default {
    name: "SchoolSaleSearch",
    props: {
        schoolId: {
            type: String,
            required: false,
            default: null
        }
    },
    created() {
        if (this.schoolId) {
            this.getSchoolById();
        }
    },
    data: () => ({
        search: '',
        searchResults: [],
        schools: [],
        school_id: ''
    }),
    methods: {
        async searchHandler() {
            if (this.search) {
                await this.getAllSchools(this);
            }
        },
        getAllSchools: debounce(async (self) => {
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
        setCurrentSchool(school) {
            this.schools = [];
            this.schools.push({id: school.id, name: school.name});
            this.search = '';
            this.searchResults = [];
            this.setSchoolId();
        },
        setSchoolId() {
            this.school_id = this.schools[0].id;
        },
        removeSchool(id) {
            this.schools = this.schools.filter(s => s.id !== id);
        },
        async getSchoolById() {
            await API.schoolsEndpoint.getSchool(this.schoolId)
                .then(response => {
                    if (response.data.status) {
                        this.schools.push({id: response.data.data.result.id, name: response.data.data.result.name});
                        this.setSchoolId();
                    }
                })
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
