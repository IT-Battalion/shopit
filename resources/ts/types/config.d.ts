export interface GlobalConfig {
    categories: {
        id: string,
        name: string,
        icon_name: string,
        icon_url: string,
    }[]
    user: {
        logged_in: boolean,
    },
}