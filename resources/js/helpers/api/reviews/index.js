import {REVIEWS, createAxiosJsonRequest, createAxiosRequest, SCHOOLS, COURSES} from "../base";
export default {
    getReviews(filters, page) {
        let f = `?page=${page}`;
        for (const [k, v] of Object.entries(filters)) {
            f += `&${k}=${v}`;
            if ((k === 'date_from' || k === 'date_to') && v) {
                f += `&${k}=${new Date(v).toLocaleDateString('ru')}`
            }
        }

        return createAxiosJsonRequest(`${REVIEWS}${f}`);
    },
    getReview(id) {
        return createAxiosJsonRequest(`${REVIEWS}/${id}`);
    },
    getStatusesList(){
        return createAxiosJsonRequest(`${REVIEWS}/statuses-list`, 'get')
    },
    getSourcesList(){
        return createAxiosJsonRequest(`${REVIEWS}/sources-list`, 'get')
    },
    getUsersList() {
        return createAxiosJsonRequest(`${REVIEWS}/users-list`);
    },
    getSchoolsList() {
        return createAxiosJsonRequest(`${SCHOOLS}/all-list`);
    },
    getCoursesList() {
        return createAxiosJsonRequest(`${COURSES}/all-list`);
    },
    getStatuses() {
        return createAxiosJsonRequest(`${REVIEWS}/statuses`);
    },
    changeStatus(ids, status) {
        return createAxiosJsonRequest(`${REVIEWS}/status-change`, 'put', {ids, status});
    },
    removeMultiple(ids) {
        return createAxiosJsonRequest(`${REVIEWS}/remove-multiple`, 'post', {ids})
    },
    save(data) {
        return createAxiosRequest(`${REVIEWS}`, 'post', data);
    }
}
