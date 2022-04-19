export interface Category {
    id: number;
    title: string;
    slug: string;
    img?: string;
    products_count: number;
}

export const emptyCategory: Category = {
    id: 0,
    title: "",
    slug: "",
    img: undefined,
    products_count: 0,
};

export interface ProductInterface {
    id: number;
    category: Category;
    title: string;
    slug: string;
    img?: string;
    amount: number;
    sell_price: number;
    buy_price: number;
}

export const emptyProduct: ProductInterface = {
    id: 0,
    category: emptyCategory,
    title: '',
    slug: '',
    img: undefined,
    amount: 1,
    sell_price: 1,
    buy_price: 1,
}

export interface Sale {
    id: number;
    type: 'sell' | 'buy';
    amount: number;
    total: number;
    updated_at: string;
    product: ProductInterface;
}

export const emptySale: Sale = {
    id: 0,
    type: 'sell',
    amount: 0,
    total: 0,
    updated_at: '',
    product: emptyProduct,
}