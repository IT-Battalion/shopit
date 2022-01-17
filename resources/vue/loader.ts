import {computed, ComputedRef, nextTick, reactive, UnwrapNestedRefs, watchEffect} from "vue";

export const state: UnwrapNestedRefs<{ isLoading: boolean; handlers: ((value: unknown) => void)[]; progressTarget: number; progressCurrent: number; progressPercent: ComputedRef<number>; isProgressing: ComputedRef<boolean> }> = reactive({
  isLoading: false,
  progressTarget: Number.MAX_VALUE,
  progressCurrent: Number.MAX_VALUE,
  progressPercent: computed(() => state.isLoading ? 1 : state.progressCurrent/state.progressTarget),
  isProgressing: computed(() => state.progressTarget !== Number.MAX_VALUE && state.progressCurrent !== state.progressTarget),
  handlers: [],
});

export function initLoad() {
  console.trace('initLoad');
  state.isLoading = true;
}

export function initProgress(target: number) {
  state.isLoading = false;
  state.progressTarget = target;
  state.progressCurrent = 0;
}

export function complete() {
  state.isLoading = false;
  state.progressTarget = Number.MAX_VALUE;
  state.progressCurrent = Number.MAX_VALUE;

  console.log(state);

  nextTick().then(() => {
    state.handlers.forEach(handler => {
      handler(undefined);
    });
    state.handlers = [];
  });
}

export function onLoaded() {
  return new Promise((res, _) => {
    state.handlers.push(res);
  });
}

watchEffect(() => {
  if (!state.isProgressing && state.progressCurrent === state.progressTarget) {
    complete();
  }
});
