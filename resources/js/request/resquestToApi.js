import csrf from "@base/js/csrf_token";

export function resquestToApi(url) {
    const cookieValue = document.cookie
        .split('; ')
        .find(row => row.startsWith('XSRF-TOKEN='))
        .split('=')[1];

    return fetch(url, {
        "headers": {
            "Accept": "application/json",
            'X-XSRF-TOKEN': cookieValue
        }
    })
        .then((response) => response.json())
        .then((response) => {
            return response;
        });
}

export function postToApi(url, data) {
    return fetch(url, {
        method: "POST",
        "headers": {
            "Accept": "application/json",
            'X-CSRF-TOKEN': csrf()
        },
        body:  JSON.stringify(data)
    })
        .then((response) => response.json())
        .then((response) => {
            return response;
        });
}
