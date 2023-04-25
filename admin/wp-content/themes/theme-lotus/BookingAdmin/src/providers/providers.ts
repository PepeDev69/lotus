import { InjectionKey, Ref } from "vue";

export const ProvideSchedule: InjectionKey<SampleSchedule> = Symbol("schedule");

export const ProvideUser = Symbol('user') as InjectionKey<Ref<UserStore>>

