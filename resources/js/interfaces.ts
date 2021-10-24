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
    price: number;
}

export const emptyProduct: ProductInterface = {
    id: 0,
    category: emptyCategory,
    title: '',
    slug: '',
    img: undefined,
    amount: 1,
    price: 1,
}