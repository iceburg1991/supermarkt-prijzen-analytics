import './bootstrap';

import Alpine from 'alpinejs';
import chartBar from './chart-bar.js';
import chartLine from './chart-line.js';

window.Alpine = Alpine;

Alpine.data('chartBar', chartBar);
Alpine.data('chartLine', chartLine);

Alpine.start();
