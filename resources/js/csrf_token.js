export default function() {
    return document.querySelector('meta[name="csrf-token"]').content;
}