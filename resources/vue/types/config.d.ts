export interface GlobalConfig {
    categories: {
        id: string,
        name: string,
        icon_name: string,
        icon_url: string,
    }[]
    user: {
        logged_in: boolean,
        username?: string,
        name?: string,
        firstname?: string,
        lastname?: string,
        email?: string,
        employeeType?: string,
        class?: string,
        lang?: string,
        isAdmin?: boolean,
    },
}