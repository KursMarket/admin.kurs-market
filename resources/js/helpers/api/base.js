import axios from "axios";
export const API_BASE = '/api';
export const SCHOOLS = `${API_BASE}/schools`;
export const CATEGORIES = `${API_BASE}/categories`;
export const TAGS = `${API_BASE}/tags`;
export const TYPES = `${API_BASE}/types`;
export const DURATIONS = `${API_BASE}/durations`;
export const COURSES = `${API_BASE}/courses`;
export const SETTINGS = `${API_BASE}/settings`;
export const REVIEWS = `${API_BASE}/review`;

export const createAxiosRequest = (url, method, data = null) => {
    const requestObject = {
        method: method,
        url: url
    };

    if (data !== null) {
        requestObject.data = data;
        requestObject.headers = {
            'Content-Type': 'multipart/form-data'
        };
    }

    return axios(requestObject);
};

export const createAxiosJsonRequest = (url, method, data = null, headers = null) => {
    const requestObject = {
        method: method,
        url: url
    };

    if (data !== null) {
        requestObject.data = data;
    }

    if (headers !== null) {
        requestObject.headers = headers
    }

    return axios(requestObject);
};
