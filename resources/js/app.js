import $ from "jquery";
window.$ = window.jQuery = $;

import { Fancybox } from "@fancyapps/ui/src/Fancybox/Fancybox.js";
import { OwlCarousel } from "owl.carousel/dist/owl.carousel.min.js";
import { Parsleyjs } from "parsleyjs/dist/parsley.min.js";
import { ParsleyjsTraduction } from "parsleyjs/dist/i18n/pt-br.js";
import { JqueryMask } from "jquery-mask-plugin/dist/jquery.mask.min.js";
import { AutoNumeric } from "autonumeric/dist/autoNumeric.min.js";
import { Popper } from "popper.js/dist/popper.min.js";
import { Dropdown } from "bootstrap/js/dist/dropdown.js";
import { Collapse } from "bootstrap/js/dist/collapse.js";
import { Tab } from "bootstrap/js/dist/tab.js";
import { Toast } from "jquery-toast-plugin/dist/jquery.toast.min.js";
import "./audioplayer";

// FULL CALENDAR

import { Calendar } from '@fullcalendar/core';
import dayGridPlugin from '@fullcalendar/daygrid';
import timeGridPlugin from '@fullcalendar/timegrid';
import listPlugin from '@fullcalendar/list';



import { FormValidate } from "../views/Admin/assets/js/pages/form-validation.init.js";
import { FormMask } from "../views/Admin/assets/js/pages/form-masks.init.js";
import { base } from "../views/Client/assets/js/base";
import { config } from "../views/Client/assets/js/config";
import { cjax } from "../views/Client/assets/js/ajax";
