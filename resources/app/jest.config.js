module.exports = {
	preset: '@vue/cli-plugin-unit-jest/presets/typescript-and-babel',
	moduleFileExtensions: ['js', 'ts', 'json', 'vue'],
	moduleNameMapper: {
		'@/(.*)$': '<rootDir>/src/$1',
		'@imgs/(.*)$': '<rootDir>/src/assets/$1',
		'@plugins/(.*)$': '<rootDir>/src/plugins/$1'
	},
	transform: {
		'^.+\\.tsx?$': 'ts-jest'
	},
	testMatch: ['<rootDir>/__tests__/unit/**/*.spec.[jt]s?(x)', '<rootDir>/__tests__/*.[jt]s?(x)'],
	// testRegex: '(/__tests__/unit/.*|(\\.|/)(test|spec))\\.(jsx?|tsx?)$',
	testURL: 'http://localhost/'
}
