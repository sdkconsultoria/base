export function getAllErrorsAsArray(errors) {
    let error_list = [];
    for (let index = 0; index < errors.length; index++) {
        const service_error = errors[index];
        eachObject(error_list, service_error);
    }

    return error_list;
}


function eachObject(error_list, errors) {
    Object.values(errors).forEach(attribute => {
        if (typeof attribute == 'string') {
            error_list.push(attribute);
        }
        if (typeof attribute == 'object') {
            eachObject(error_list, attribute);
        }
    });
}
