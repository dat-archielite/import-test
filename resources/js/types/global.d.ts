import { AxiosInstance } from 'axios'
import { Alpine as AlpineInstance } from 'alpinejs'
import { formatPrice, formatNumber } from '@/utils'

declare global {
    interface Window {
        axios: AxiosInstance
        Alpine: AlpineInstance
        formatPrice: formatPrice
        formatNumber: formatNumber
    }
}
