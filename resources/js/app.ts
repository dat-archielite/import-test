import './bootstrap'

import Alpine from 'alpinejs'
import axios, { AxiosResponse } from 'axios'
import * as FilePond from 'filepond'
import { FilePondFile, FilePondOptions } from 'filepond'
import FilePondPluginFileValidateType from 'filepond-plugin-file-validate-type'
import { notify } from './utils'
import {Product, ResourceController} from '@/types'

FilePond.registerPlugin(FilePondPluginFileValidateType)

Alpine.data('products', () => ({
    loading: false,
    importing: false,
    total: 0,
    products: [],

    async init(): Promise<void> {
        await this.getProducts()

        const csrfToken: string | null = (document.querySelector('meta[name="csrf-token"]') as HTMLMetaElement).content
        const options: FilePondOptions = {
            credits: false,
            name: 'file',
            server: {
                url: '/filepond/process',
                headers: {
                    'X-CSRF-TOKEN': csrfToken || '',
                },
            },
            chunkUploads: true,
            chunkSize: 5000000,
        }

        const filepond: FilePond.FilePond = FilePond.create(document.querySelector('input') as HTMLInputElement, options)

        document.addEventListener('FilePond:processfile', (event: Event) => {
            this.$dispatch('close')

            filepond.removeFiles()

            notify('Your CSV file has been uploaded successfully. Import products is in progress.', 'info')

            this.import(event)
        })
    },

    async truncate(): Promise<void> {
        this.loading = true

        const response: AxiosResponse<{ message: string }> = await axios.delete('/products/truncate')

        this.products = []
        this.total = 0
        this.loading = false

        this.$dispatch('close')
        notify(response.data.message, 'success')
    },

    async getProducts(): Promise<void> {
        this.loading = true

        const response: AxiosResponse<object> = await axios.get('/products')

        const { data, meta } = response.data as ResourceController<Product>

        this.products = data
        this.total = meta.total

        this.loading = false
    },

    async import(event: Event): Promise<void> {
        this.importing = true

        const file: FilePondFile = (<CustomEvent>event).detail.file

        const response: AxiosResponse<{ message: string }> = await axios.post('/products/import', { serverId: file.serverId })

        this.importing = false

        notify(response.data.message, 'success')

        await this.getProducts()
    }
}))

Alpine.start()
