export const common = {
    methods: {
        getFormData (ref) {
            const formData = new FormData(this.$refs[ref]); // reference to form element
            const data = {}; // need to convert it before using not with XMLHttpRequest
            for (let [key, val] of formData.entries()) {
                Object.assign(data, { [key]: val });
            }
            return data;
        },
    }
}
