export const vfMixins = {
    methods: {
        arrayKeyExists(key, search) {
            if (!search || (search.constructor !== Array && search.constructor !== Object)) {
                return false;
            }

            return search[key] !== undefined;

        },
        errorsAnswerHandling(error) {
            const serverErrors = {};
            const responseErrors = error?.response?.data?.errors;

            if (responseErrors) {
                for (const e in responseErrors) {
                    serverErrors[e] = responseErrors[e].join(' ');
                }
            }
            if (this.arrayKeyExists('account_is_blocked', serverErrors)) {
                alert(serverErrors.account_is_blocked);
            }
            return serverErrors;
        },
        validateEmail(email) {
            return String(email)
                .toLowerCase()
                .match(
                    /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/
                );
        },
    }
};

export default vfMixins;
