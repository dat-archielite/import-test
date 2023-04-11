import './bootstrap'

import Alpine from 'alpinejs'
import * as FilePond from 'filepond'
import FilePondPluginFileValidateType from 'filepond-plugin-file-validate-type'
import { notify } from './utils'

window.Alpine = Alpine

Alpine.start()

FilePond.registerPlugin(FilePondPluginFileValidateType)

FilePond.create(document.querySelector('input'), {
    credits: false,
    name: 'file',
    server: {
        url: '/filepond/process',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
    },
    chunkUploads: true,
    chunkSize: 5000000,
})

document.addEventListener('FilePond:processfile', (e) => {
    notify('Your CSV file has been uploaded successfully. Import products is in progress.', 'info')

    const serverId = e.detail.file.serverId

    axios.post('/products/import', { serverId })
        .then(response => {
            notify(response.data.message, 'success')
        })
})


