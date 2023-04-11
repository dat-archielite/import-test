const notify = (content: string, type: string) => {
    window.dispatchEvent(new CustomEvent('notify', { detail: { content, type } }))
}

export { notify }
