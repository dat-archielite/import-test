import axios from 'axios'
import Alpine from 'alpinejs'
import { formatNumber, formatPrice } from '@/utils'

window.Alpine = Alpine
window.axios = axios
window.formatPrice = formatPrice
window.formatNumber = formatNumber

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest'
