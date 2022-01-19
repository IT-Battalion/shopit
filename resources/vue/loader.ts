import { computed, ComputedRef, nextTick, reactive, UnwrapNestedRefs, watchEffect } from "vue";

export const state: UnwrapNestedRefs<{ isLoading: ComputedRef<boolean>; waiting: number; handlers: any[]; progressTarget: number; progressCurrent: number; progressPercent: ComputedRef<number>; isProgressing: ComputedRef<boolean> }> = reactive({
  waiting: 0,
  isLoading: computed(() => state.waiting > 0),
  progressTarget: Number.MAX_VALUE,
  progressCurrent: Number.MAX_VALUE - 1,
  progressPercent: computed(() => state.isLoading ? 1 : state.progressCurrent / state.progressTarget),
  isProgressing: computed(() => state.progressTarget !== Number.MAX_VALUE && state.progressCurrent !== state.progressTarget),
  handlers: [],
});

export function initLoad() {
  state.waiting += 1;
}

export function initProgress(target: number) {
  if (state.progressTarget === Number.MAX_VALUE) {
    state.progressTarget = target;
    state.progressCurrent = 0;
  } else {
    state.progressTarget += target;
  }
}

export function endLoad() {
  if (state.waiting < 0) {
    state.waiting = 0;
    return;
  }
  state.waiting -= 1;
}

function complete() {
  state.progressTarget = Number.MAX_VALUE;
  state.progressCurrent = Number.MAX_VALUE;
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

watchEffect(() => {
  if (state.waiting <= 0 && state.progressTarget === state.progressCurrent) {
    state.waiting = 0;
    nextTick().then(() => {
      state.handlers.forEach(handler => {
        handler(undefined);
      });
      state.handlers = [];
    });
  }
})
