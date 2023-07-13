import {SCHOOLS, createAxiosJsonRequest, createAxiosRequest} from "../base";
export default {
    getAllSchools(filters, page) {
        let f = `?page=${page}`;
        for (const [k, v] of Object.entries(filters)) {
            f += `&${k}=${v}`;
        }
        return createAxiosJsonRequest(`${SCHOOLS}${f}`);
    },
    changeStatuses(ids, status) {
        return createAxiosJsonRequest(`${SCHOOLS}/change-status`, 'put', {ids, status});
    },
    removeSchools(ids) {
        return createAxiosJsonRequest(`${SCHOOLS}/delete`, 'post', {ids});
    },
    saveSchool(data) {
        return createAxiosRequest(`${SCHOOLS}/save`, 'post', data);
    },
    getSchool(schoolId) {
        return createAxiosJsonRequest(`${SCHOOLS}/get?schoolId=${schoolId}`, 'get');
    },
    removeLogo(schoolId) {
        return createAxiosJsonRequest(`${SCHOOLS}/remove-logo/${schoolId}`, 'delete');
    }
}
