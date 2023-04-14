interface ResourceController<T> {
    data: T[],
    links: {
        first: string,
        last: string,
        prev: string,
        next: string,
    },
    meta: {
        current_page: number,
        from: number,
        last_page: number,
        path: string,
        per_page: number,
        to: number,
        total: number,
    },
}

interface Product {
    id: number
    name: string
    sku: string
    price: number
    stock: number
    type?: string
    vendor?: string
    description?: string
    status: ProductStatus
    created_at: string
    updated_at: string
}


enum ProductStatus {
    Active = 'active',
    Inactive = 'inactive',
}

export { ResourceController, Product, ProductStatus }
