export default function(field) {
    if (this.submited) {
        if (this.errors[field]) {
            return "border-red-500";
        }

        return "border-green-500";
    }
}