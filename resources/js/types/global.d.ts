import { AxiosInstance } from 'axios'
import { Alpine as AlpineInstance } from 'alpinejs'

declare global {
    interface Window {
        axios: AxiosInstance
        Alpine: AlpineInstance
    }
}
