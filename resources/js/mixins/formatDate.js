export default {
    methods: {
        formatDate(dateString) {
            const date = new Date(dateString);
            // Then specify how you want your dates to be formatted
            return new Intl.DateTimeFormat('default').format(date);
        }
    }
}
