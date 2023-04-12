export interface Product {
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
