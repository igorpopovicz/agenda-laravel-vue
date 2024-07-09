import { createToastInterface } from 'vue-toastification';
import 'vue-toastification/dist/index.css';

const toast = createToastInterface({
  position: 'top-right',
  timeout: 5000,
  hideProgressBar: true,
  closeOnClick: true,
  pauseOnHover: true,
  draggable: true,
  draggablePercent: 0.6,
  showCloseButtonOnHover: false,
  icon: true,
  rtl: false,
});

export default toast;
