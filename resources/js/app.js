import './bootstrap';

import Alpine from 'alpinejs';
import chartBar from './chart-bar.js';

window.Alpine = Alpine;

Alpine.data('chartBar', chartBar);

Alpine.start();
