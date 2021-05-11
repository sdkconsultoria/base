function noticesHandler() {
	return {
		notices: [],
		visible: [],
		add(notice) {
			notice.id = Date.now()
			this.notices.push(notice)
			this.fire(notice.id)
		},
		fire(id) {
			this.visible.push(this.notices.find(notice => notice.id == id))
			const timeShown = 3000 * this.visible.length
			setTimeout(() => {
				this.remove(id)
			}, timeShown)
		},
		remove(id) {
			const notice = this.visible.find(notice => notice.id == id)
			const index = this.visible.indexOf(notice)
			this.visible.splice(index, 1)
		},

	};
}
window.noticesHandler = noticesHandler;
