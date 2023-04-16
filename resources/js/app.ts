import './bootstrap'

import Alpine from 'alpinejs'
import axios, { AxiosResponse } from 'axios'
import * as FilePond from 'filepond'
import { FilePondFile, FilePondOptions } from 'filepond'
import FilePondPluginFileValidateType from 'filepond-plugin-file-validate-type'
import { notify } from './utils'
import { Product, ResourceCollection } from '@/types'

FilePond.registerPlugin(FilePondPluginFileValidateType)

Alpine.data('products', () => ({
    loading: false,
    importing: false,
    meta: {},
    products: [] as Product[],

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
        this.meta = {}
        this.loading = false

        this.getProducts()

        this.$dispatch('close')
        notify(response.data.message, 'success')
    },

    async getProducts(url: string): Promise<void> {
        this.loading = true

        const response: AxiosResponse<object> = await axios.get(url || '/products')

        const { data, meta } = response.data as ResourceCollection<Product>

        this.products = data
        this.meta = meta

        this.loading = false
    },

    async import(event: Event): Promise<void> {
        this.importing = true

        const file: FilePondFile = (<CustomEvent>event).detail.file

        try {
            const response: AxiosResponse<{ message: string }> = await axios.post('/products/import', { serverId: file.serverId })

            notify(response.data.message, 'success')
            await this.getProducts()
        } catch (error: any) {
            notify(error.response.data.message, 'error')
        } finally {
            this.importing = false
        }
    }
}))

Alpine.start()
