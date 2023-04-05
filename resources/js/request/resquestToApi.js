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
