import { defineStore } from "pinia"

export const useLayoutStore = defineStore({
    id: "layout",
    state: () => ({
        layoutType: "horizontal",
        layoutWidth: "fluid",
        sidebarSize: "lg",
        topbar: "dark",
        mode: "light",
        position: "fixed",
        sidebarView: "default",
        sidebarColor: "dark",
    }),
    actions: {
        changeLayoutType(layoutType) {
            this.layoutType = layoutType
            document.body.removeAttribute("style")
        },
        changeLayoutWidth(layoutWidth) {
            this.layoutWidth = layoutWidth
        },
        changeSidebarSize(sidebarSize) {
            this.sidebarSize = sidebarSize
        },
        changeTopbar(topbar) {
            this.topbar = topbar
        },
        changeMode(mode) {
            this.mode = mode
        },
        changePosition(position) {
            this.position = position
        },
        changeSidebarView(sidebarView) {
            this.sidebarView = sidebarView
        },
        changeSidebarColor(sidebarColor) {
            this.sidebarColor = sidebarColor
        },
    },
})
