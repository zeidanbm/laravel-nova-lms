module.exports = {
	root: true,
	env: {
		node: true
	},
	extends: [
		'plugin:vue/essential',
		'eslint:recommended',
		'@vue/typescript/recommended',
		'@vue/prettier',
		'@vue/prettier/@typescript-eslint'
	],
	parserOptions: {
		ecmaVersion: 2020
	},
	rules: {
		'prettier/prettier': process.env.NODE_ENV === 'production' ? 'error' : 'off',
		'no-console': process.env.NODE_ENV === 'production' ? 'warn' : 'off',
		'no-debugger': process.env.NODE_ENV === 'production' ? 'warn' : 'off',
		'@typescript-eslint/no-explicit-any': 'off',
		'vue/component-name-in-template-casing': ['error', 'PascalCase'],
		quotes: [2, 'single', { avoidEscape: true }],
		semi: ['error', 'never'],
		'eol-last': 1
	},
	overrides: [
		{
			files: [
				'__tests__/*.{j,t}s?(x)',
				'__tests__/unit/**/*.spec.{j,t}s?(x)',
				'__tests__/es2/**/*.spec.{j,t}s?(x)'
			],
			env: {
				jest: true
			}
		}
	]
}
