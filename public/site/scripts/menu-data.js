// Menu names are sample enquiry topics for this static prototype, not published itineraries.
const menuRegion = (id, name, items) => ({
  id,
  name,
  trips: items.trim().split('\n').map((item) => item.trim()).filter(Boolean)
});

window.NEPAL_MENU = {
  trekRegions: [
    menuRegion('annapurna', 'Annapurna Region Trekking', `
14 Day Annapurna Base Camp Trek
ABC Trek from Pokhara - 6 Days
Mardi Himal Trek - 9 Days
Annapurna North Base Camp Trek - 12 Days
3 Days Poon Hill Trek from Pokhara
Annapurna Circuit Trek - 12 Days
Ghorepani Poonhill Trek - 8 Days
Short ABC Trek - 9 Days
2 Days Poon Hill Trek
Poon Hill Mardi Himal Trek - 12 Days
ABC Trek with Poon hill and Mardi Himal - 17 Days
Annapurna Base Camp Trek with Helicopter Return - 8 Days
Annapurna Tilicho Lake Trek – 16 Days
Khopra Danda Trek with Khayer Lake - 12 Days
Nar Phu Valley Trek with Kang La and Thorong La Pass- 17 Days
Nar Phu Trek with Tilicho Lake - 21 Days
Kapuche Lake with Kori Himal Trek - 11 Days
Kori Himal Trek - 10 Days
Sikles Kapuche Lake Trek - 8 Days
Mohare Danda Trek - 9 Days
Mohare Danda Khopra Trek - 14 Days
`),
    menuRegion('everest', 'Everest Region Trek', `
Everest Marathon Trek – 16 Days
Everest Base Camp Trek - 14 Days
Sleep at Base Camp on Everest Trek - 15 Days
Luxury Everest Heli Trek - 6 Days
EBC Trek via Gokyo with Helicopter Return – 15 Days
EBC Trek Helicopter Return from Pheriche - 11 Days
Three High Passes Trek by Road - 19 Days
11 Days Super Luxury Everest Base Camp Trek
Everest Three Passes Trek - 18 Days
Budget Everest Base Camp Trek - 12 Days
Everest High Passes Trek Clockwise - 18 Days
Gokyo Valley Circuit Trek - 13 Days
Everest View Trek - 9 Days
Everest Trek Cost for Indians - 14 Days
Everest Gokyo Trek via Salleri - 20 Days
12 Days Everest Base Camp Trek
Rapid (Short) Everest Base Camp Trek - 9 Days
EBC Trek via Gokyo Cho La Pass - 17 Days
Everest Base Camp Trek Helicopter Return to Kathmandu - 10 Days
Gokyo Chola Pass Trekking via EBC - 17 Days
Everest Base Camp Trek Heli Out to Lukla - 12 Days
Pikey Peak Trek - 10 Days
Everest Base Camp Trek by Road - 16 Days
`),
    menuRegion('langtang', 'Langtang Region Trekking', `
Langtang Valley Trek - 10 Days
Ama Yangri Trek - 3 Days
Langtang Gosaikunda Lake Trek – 15 Days
Gosaikunda Lake Trek - 7 Days
Tamang Heritage Trail Trek – 10 Days
Helambu Circuit Trek – 8 Days
Langtang Ganja La Pass Trek – 14 Days
`),
    menuRegion('manaslu', 'Manaslu Region Trekking', `
Manaslu Circuit Trek - 14 Days
Manaslu Luxury Trek - 17 Days
Lower Manaslu Eco Trail Trek - 12 Days
Short Manaslu Trek - 11 Days
Manaslu Tsum Valley Trek - 18 Days
Manaslu Annapurna Circuit Trek - 23 Days
Tsum Valley Trek - 15 Days
Annapurna Seven Passes Trek - 23 Days
`),
    menuRegion('mustang', 'Mustang Region Trekking', `
Mustang Tiji Festival Tour 2027 and 2028
Upper Mustang Trek - 17 Days
`),
    menuRegion('makalu', 'Makalu Region', `
Makalu Base Camp Trek - 19 Days
`),
    menuRegion('kanchenjunga', 'Kanchenjunga Region', `
Kanchenjunga North Base Camp Trek - 20 Days
Kanchenjunga South Base Camp Trek - 13 Days
Kanchenjunga Circuit Trek - 22 Days
`),
    menuRegion('short', 'Short and Easy Trek', `
Dhampus Sarangkot Trek - 3 Days
Chisapani Nagarkot Trek - 3 Days
`),
    menuRegion('yoga', 'Yoga Treks in Nepal', `
Rara Lake Yoga Trek – 12 Days
Everest Monastery Yoga Trek – 10 Days
`)
  ],
  tourGroups: [
    menuRegion('valley-tours', 'Kathmandu Valley Tours', `
Kathmandu Heritage Tour
Patan & Bhaktapur Heritage Tour
Kathmandu Valley Highlights
`),
    menuRegion('discovery-tours', 'Nepal Discovery Tours', `
Kathmandu, Pokhara & Chitwan Tour
Pokhara & Bandipur Tour
Nepal Culture & Nature Tour
`),
    menuRegion('wildlife-tours', 'Wildlife & Nature Tours', `
Chitwan Wildlife Safari
Bardia Wildlife Tour
Koshi Tappu Birdwatching Tour
`),
    menuRegion('spiritual-tours', 'Pilgrimage & Spiritual Tours', `
Lumbini Buddhist Heritage Tour
Kathmandu Sacred Sites Tour
Lumbini & Kathmandu Pilgrimage
`),
    menuRegion('custom-tours', 'Private & Custom Tours', `
Family Nepal Tour
Nepal Photography Tour
Tailor-Made Nepal Tour
`)
  ],
  climbingGroups: [
    menuRegion('everest-peaks', 'Everest Region Peaks', `
Island Peak (Imja Tse) Climbing
Mera Peak Climbing
Lobuche East Peak Climbing
`),
    menuRegion('annapurna-peaks', 'Annapurna Region Peaks', `
Pisang Peak Climbing
Chulu East Peak Climbing
Chulu West Peak Climbing
`),
    menuRegion('langtang-peaks', 'Langtang Region Peaks', `
Yala Peak Climbing
Naya Kanga Peak Climbing
`)
  ]
};
