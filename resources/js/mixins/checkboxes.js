export const vfCheckboxes = {
    data: () => ({
        ids: [],
        allSelected: false,
    }),
    methods: {
        selectAllCheckboxes(e, tags) {
            this.ids = [];
            if (e.target.checked) {
                if (tags.length) {
                    for (const s in tags) {
                        this.ids.push(tags[s].id)
                    }
                }
            }
        },
        checkCurrentSchool(id, e) {
            if (!e.target.checked) {
                this.ids = this.ids.filter(s => s !== id);
            } else {
                if (!this.ids.find(s => s === id)) {
                    this.ids.push(id);
                }
            }
        }
    }
}

export default vfCheckboxes;
