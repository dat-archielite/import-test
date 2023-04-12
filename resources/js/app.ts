import './bootstrap'

import Alpine from 'alpinejs'
import axios from 'axios'
import * as FilePond from 'filepond'
import FilePondPluginFileValidateType from 'filepond-plugin-file-validate-type'
import { notify } from './utils'
import { FilePondFile } from 'filepond'

window.Alpine = Alpine

Alpine.start()

FilePond.registerPlugin(FilePondPluginFileValidateType)

const csrfToken: string | null = (document.querySelector('meta[name="csrf-token"]') as HTMLMetaElement).content

FilePond.create(document.querySelector('input') as HTMLInputElement, {
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
})

document.addEventListener('FilePond:processfile', (event: Event) => {
    notify('Your CSV file has been uploaded successfully. Import products is in progress.', 'info')

    const file: FilePondFile = (<CustomEvent>event).detail.file

    axios.post('/products/import', { serverId: file.serverId })
        .then(response => {
            notify(response.data.message, 'success')
        })
})


