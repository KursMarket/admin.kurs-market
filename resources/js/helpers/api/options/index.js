import {SETTINGS, API_BASE, SCHOOLS, createAxiosRequest, createAxiosJsonRequest} from "../base";
export default {
    saveMainBannerOption(data) {
        return createAxiosRequest(`${SETTINGS}/banner/save`, 'post', data);
    },
    getBannerSetting() {
        return createAxiosJsonRequest(`${SETTINGS}/banner/get`);
    },
    removeImage() {
        return createAxiosJsonRequest(`${SETTINGS}/banner/remove-image`, 'delete');
    },
    saveAdvantages(data) {
        return createAxiosJsonRequest(`${SETTINGS}/advantages/save`, 'post', data);
    },
    getAdvantages() {
        return createAxiosJsonRequest(`${SETTINGS}/advantages/get`);
    },
    editAdvantages(data, id) {
        return createAxiosJsonRequest(`${SETTINGS}/advantages/${id}/edit`, 'put', data);
    },
    removeAdvantage(id) {
        return createAxiosJsonRequest(`${SETTINGS}/advantages/${id}/delete`, 'delete');
    },
    saveQuiz(data) {
        return createAxiosJsonRequest(`${SETTINGS}/quiz/save`, 'post', data);
    },
    getQuiz() {
        return createAxiosJsonRequest(`${SETTINGS}/quiz/get`);
    },
    getPromoModule() {
        return createAxiosJsonRequest(`${SETTINGS}/promo/get`)
    },
    getSchoolsByName(search, ids) {
        let queryString = `?name=${search}`;
        if (ids.length) {
            queryString += `&ids=${ids.join(',')}`
        }
        return createAxiosJsonRequest(`${API_BASE}${SCHOOLS}/search${queryString}`)
    },
    savePromoModule(data) {
        return createAxiosJsonRequest(`${SETTINGS}/promo/save`, 'post', data);
    },
    saveCollaboration(data) {
        return createAxiosJsonRequest(`${SETTINGS}/collaboration/save`, 'post', data);
    },
    getCollaborationModule() {
        return createAxiosJsonRequest(`${SETTINGS}/collaboration/get`)
    }
}
