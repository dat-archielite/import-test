import './bootstrap'

import Alpine from 'alpinejs'
import axios from 'axios'
import * as FilePond from 'filepond'
import { FilePondFile, FilePondOptions } from 'filepond'
import FilePondPluginFileValidateType from 'filepond-plugin-file-validate-type'
import { notify } from './utils'
import { Product } from '@/types'

FilePond.registerPlugin(FilePondPluginFileValidateType)

Alpine.data('products', () => ({
    products: Array<Product>,

    init() {
        axios.get('/products').then(response => this.products = response.data)

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

        FilePond.create(document.querySelector('input') as HTMLInputElement, options)

        document.addEventListener('FilePond:processfile', (event: Event) => {
            notify('Your CSV file has been uploaded successfully. Import products is in progress.', 'info')

            const file: FilePondFile = (<CustomEvent>event).detail.file

            axios.post('/products/import', { serverId: file.serverId })
                .then(response => {
                    notify(response.data.message, 'success')
                })
        })
    }
}))

Alpine.start()
