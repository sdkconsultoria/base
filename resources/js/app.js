import Alpine from '@node/alpinejs'
import toast from './toast'
import './components.js'
// import './jodit'
import './barcode.js';

toast();
window.Alpine = Alpine;

Alpine.start();
