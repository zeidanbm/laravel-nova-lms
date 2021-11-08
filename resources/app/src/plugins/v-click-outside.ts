import { DirectiveOptions } from 'vue'
import { DirectiveBinding } from 'vue/types/options'

type CustomHTMLElement = HTMLElement & { _clickOutside?: EventListener }

export const clickOutside: DirectiveOptions = {
	bind(el: CustomHTMLElement, binding: DirectiveBinding) {
		const onClick = ((e: PointerEvent) => {
			if (!e || ('isTrusted' in e && !e.isTrusted) || ('pointerType' in e && !e.pointerType)) {
				return
			}
			!el.contains(e.target as Node) && setTimeout(() => binding.value && binding.value(e))
		}) as EventListener

		const app = document.querySelector('#__nuxt') || document.body

		app.addEventListener('click', onClick, true)
		el._clickOutside = onClick
	},
	unbind(el: CustomHTMLElement) {
		if (!el._clickOutside) {
			return
		}

		const app = document.querySelector('#__nuxt') || document.body

		app.removeEventListener('click', el._clickOutside, true)
		delete el._clickOutside
	}
}
