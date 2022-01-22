import { User } from "./api";

export interface GlobalConfig {
  categories: {
    id: string,
    name: string,
  }[]
  user: User,
}
