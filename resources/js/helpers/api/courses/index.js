import {COURSES, createAxiosJsonRequest, createAxiosRequest} from "../base";
export default {
    getCourse(id) {
        return createAxiosJsonRequest(`${COURSES}/get/${id}`);
    },
    removeImage(courseId) {
        return createAxiosJsonRequest(`${COURSES}/image/${courseId}`, 'delete');
    },
    getAllSchools() {
        return createAxiosJsonRequest(`${COURSES}/schools`);
    },
    getStatuses() {
        return createAxiosJsonRequest(`${COURSES}/statuses`);
    },
    getCategories() {
        return createAxiosJsonRequest(`${COURSES}/categories`);
    },
    getSubCategory(id) {
        return createAxiosJsonRequest(`${COURSES}/${id}/get-subcategories`);
    },
    getCourses(filters, page) {
        let f = `?page=${page}`;
        for (const [k, v] of Object.entries(filters)) {
            f += `&${k}=${v}`;
            if ((k === 'date_from' || k === 'date_to') && v) {
                f += `&${k}=${new Date(v).toLocaleDateString('ru')}`
            }
        }

        return createAxiosJsonRequest(`${COURSES}${f}`);
    },
    changeStatus(ids, status) {
        return createAxiosJsonRequest(`${COURSES}/status-change`, 'put', {ids, status});
    },
    removeMultiple(ids) {
        return createAxiosJsonRequest(`${COURSES}/remove`, 'post', {ids})
    },
    getAllTags() {
        return createAxiosJsonRequest(`${COURSES}/tags`);
    },
    getAllDurations() {
        return createAxiosJsonRequest(`${COURSES}/durations`);
    },
    save(data) {
        return createAxiosRequest(`${COURSES}/save`, 'post', data);
    }
}
