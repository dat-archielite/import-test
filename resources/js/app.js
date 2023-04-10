import './bootstrap'

import Alpine from 'alpinejs'
import * as FilePond from 'filepond'
import FilePondPluginFileValidateType from 'filepond-plugin-file-validate-type'

window.Alpine = Alpine

Alpine.start()

FilePond.registerPlugin(FilePondPluginFileValidateType)

const pond = FilePond.create(document.querySelector('input'), {
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
    const serverId = e.detail.file.serverId

    axios.post('/products/import', { serverId })
        .then(response => {
            console.log(response)
        })
})
