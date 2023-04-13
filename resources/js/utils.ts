const notify = (content: string, type: string) => {
    window.dispatchEvent(new CustomEvent('notify', { detail: { content, type } }))
}

const formatPrice = (price: number) => {
    return new Intl.NumberFormat('en-US', { style: 'currency', currency: 'USD' }).format(price)
}

const formatNumber = (number: number) => {
    return new Intl.NumberFormat('en-US').format(number)
}

export { notify, formatPrice, formatNumber }
