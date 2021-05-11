import '@node/jodit/build/jodit.es2018.min.css';
import { Jodit } from '@node/jodit/build/jodit.es2018.min.js';

var elementExists = document.getElementsByClassName("jodit");

if (elementExists.length) {
    var editor = new Jodit('.jodit', {
        width: '100%',
        height: 300
    });
}
