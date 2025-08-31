// घिमिरे परिवारको डाटा संरचना
const familyData = {
    families: {
        ghimire: {
            id: "family_ghimire",
            surname: "घिमिरे",
            origin: "अर्घाखाँची/गुल्मी क्षेत्र",
            rootMemberId: "sodu_ghimire"
        }
    },
    members: {
        // मूल पुरुष
        "sodu_ghimire": {
            id: "sodu_ghimire",
            familyId: "family_ghimire",
            name: "सोदु जैसी घिमिरे",
            nameEn: "Sodu Jaisi Ghimire",
            gender: "male",
            generation: 1,
            relation: "कुलपुरुष",
            birthplace: "अर्घाखाँची",
            location: "मुख्य खलक",
            profession: "कृषि",
            additionalInfo: "सम्पूर्ण घिमिरे परिवारका मूल पुरुष। धेरै सन्तानहरूको बुबा।",
            spouse: ["jamuna_ghimire"],
            children: ["harilal_ghimire", "dhanishwar_ghimire", "harnarayan_ghimire", "dilaram_ghimire", "veduram_ghimire"],
            branch: "मुख्य खलक"
        },
        "jamuna_ghimire": {
            id: "jamuna_ghimire",
            familyId: "family_ghimire",
            name: "जमुना घिमिरे",
            nameEn: "Jamuna Ghimire",
            gender: "female",
            generation: 1,
            relation: "जीवनसाथी",
            spouse: ["sodu_ghimire"],
            children: ["harilal_ghimire", "dhanishwar_ghimire", "harnarayan_ghimire", "dilaram_ghimire", "veduram_ghimire"]
        },

        // पहिलो पुस्ता - छोराहरू
        "harilal_ghimire": {
            id: "harilal_ghimire",
            familyId: "family_ghimire",
            name: "हरिलाल घिमिरे",
            nameEn: "Harilal Ghimire",
            gender: "male",
            generation: 2,
            relation: "छोरा (जेठो)",
            parents: ["sodu_ghimire", "jamuna_ghimire"],
            birthplace: "अर्घाखाँची",
            location: "बुढा घरे ओर्द सारा",
            profession: "कृषि",
            branch: "बुढा घरे ओर्द सारा",
            spouse: [],
            children: ["bhaktiram_ghimire_harilal", "dhanishwar_ghimire_harilal"]
        },
        "dhanishwar_ghimire": {
            id: "dhanishwar_ghimire",
            familyId: "family_ghimire",
            name: "धनीश्वर घिमिरे",
            nameEn: "Dhanishwar Ghimire",
            gender: "male",
            generation: 2,
            relation: "छोरा (माइला)",
            parents: ["sodu_ghimire", "jamuna_ghimire"],
            nickname: "भिरकुने",
            birthplace: "अर्घाखाँची",
            location: "भिरकुने",
            profession: "कृषि",
            branch: "भिरकुने",
            spouse: [],
            children: ["thaneshwar_ghimire"]
        },
        "harnarayan_ghimire": {
            id: "harnarayan_ghimire",
            familyId: "family_ghimire",
            name: "हरी नारायण घिमिरे",
            nameEn: "Hari Narayan Ghimire",
            gender: "male",
            generation: 2,
            relation: "छोरा (साईला)",
            parents: ["sodu_ghimire", "jamuna_ghimire"],
            nickname: "फुर्साभिरे",
            birthplace: "अर्घाखाँची",
            location: "फुर्साभिरे",
            profession: "कृषि",
            branch: "फुर्साभिरे",
            spouse: ["ganga_ghimire"],
            children: ["namdev_ghimire", "mansaram_ghimire", "bhaktiram_ghimire_junior"]
        },
        "dilaram_ghimire": {
            id: "dilaram_ghimire",
            familyId: "family_ghimire",
            name: "दिलाराम घिमire",
            nameEn: "Dilaram Ghimire",
            gender: "male",
            generation: 2,
            relation: "छोरा (काइँला)",
            parents: ["sodu_ghimire", "jamuna_ghimire"],
            nickname: "बैँशारूखे",
            birthplace: "अर्घाखाँची",
            location: "बैँशारूखे",
            profession: "कृषि",
            branch: "बैँशारूखे",
            spouse: [],
            children: ["maniram_ghimire"]
        },
        "veduram_ghimire": {
            id: "veduram_ghimire",
            familyId: "family_ghimire",
            name: "वेदुराम घिमिरे",
            nameEn: "Veduram Ghimire",
            gender: "male",
            generation: 2,
            relation: "छोरा (कान्छो)",
            parents: ["sodu_ghimire", "jamuna_ghimire"],
            nickname: "बाँसारूखे",
            birthplace: "अर्घाखाँची",
            location: "बाँसारूखे, देराधुम",
            profession: "कृषि",
            branch: "बाँसारूखे",
            spouse: [],
            children: []
        },

        // हरी नारायणका परिवार
        "ganga_ghimire": {
            id: "ganga_ghimire",
            familyId: "family_ghimire",
            name: "गंगा घिमिरे",
            nameEn: "Ganga Ghimire",
            gender: "female",
            generation: 2,
            relation: "जीवनसाथी",
            parents: [],
            spouse: ["harnarayan_ghimire"],
            children: ["namdev_ghimire", "mansaram_ghimire", "bhaktiram_ghimire_junior"]
        },
        "namdev_ghimire": {
            id: "namdev_ghimire",
            familyId: "family_ghimire",
            name: "नामदेव घिमिरे",
            nameEn: "Namdev Ghimire",
            gender: "male",
            generation: 3,
            relation: "छोरा (जेठो)",
            parents: ["harnarayan_ghimire", "ganga_ghimire"],
            birthplace: "फुर्साभिरे",
            profession: "कृषि",
            branch: "फुर्साभिरे",
            spouse: ["gomati_ghimire"],
            children: ["sashidhar_ghimire", "dadhiram_ghimire", "punaram_ghimire"]
        },
        "mansaram_ghimire": {
            id: "mansaram_ghimire",
            familyId: "family_ghimire",
            name: "मन्सराम घिमिरे",
            nameEn: "Mansaram Ghimire",
            gender: "male",
            generation: 3,
            relation: "छोरा (माइलो)",
            parents: ["harnarayan_ghimire", "ganga_ghimire"],
            birthplace: "फुर्साभिरे",
            profession: "कृषि",
            branch: "फुर्साभिरे",
            spouse: ["topli_ghimire"],
            children: ["tikaram_ghimire", "tilakram_ghimire", "jivalal_ghimire"]
        },
        "bhaktiram_ghimire_junior": {
            id: "bhaktiram_ghimire_junior",
            familyId: "family_ghimire",
            name: "भक्तिराम घिमिरे",
            nameEn: "Bhaktiram Ghimire",
            gender: "male",
            generation: 3,
            relation: "छोरा (कान्छो)",
            parents: ["harnarayan_ghimire", "ganga_ghimire"],
            birthplace: "फुर्साभिरे",
            profession: "कृषि",
            branch: "फुर्साभिरे",
            spouse: ["narikala_ghimire"],
            children: ["bhimalal_ghimire", "tilakram_ghimire_junior", "jivalal_ghimire_junior"]
        },

        // दुलिखर्के शाखा
        "dharmagat_ghimire": {
            id: "dharmagat_ghimire",
            familyId: "family_ghimire",
            name: "धर्मागत घिमिरे",
            nameEn: "Dharmagat Ghimire",
            gender: "male",
            generation: 2,
            relation: "दुलिखर्के प्रमुख",
            nickname: "खोतले मुख्या",
            birthplace: "दुलिखर्के",
            location: "दुलिखर्के",
            profession: "कृषि, सामाजिक नेतृत्व",
            branch: "दुलिखर्के",
            spouse: [],
            children: ["bhaktiram_ghimire_dharma"]
        },
        "bhaktiram_ghimire_dharma": {
            id: "bhaktiram_ghimire_dharma",
            familyId: "family_ghimire",
            name: "भक्तिराम घिमिरे",
            nameEn: "Bhaktiram Ghimire",
            gender: "male",
            generation: 3,
            relation: "छोरा",
            parents: ["dharmagat_ghimire"],
            birthplace: "दुलिखर्के",
            profession: "कृषि",
            branch: "दुलिखर्के",
            spouse: ["punakala_ghimire"],
            children: ["tikaram_ghimire_duli", "gangaram_ghimire_duli"]
        },

        // खौला शाखा
        "bhagirath_ghimire": {
            id: "bhagirath_ghimire",
            familyId: "family_ghimire",
            name: "भागीरथ घिमिरे",
            nameEn: "Bhagirath Ghimire",
            gender: "male",
            generation: 2,
            relation: "खौला प्रमुख",
            nickname: "खौला",
            birthplace: "खौला",
            location: "खौला",
            profession: "कृषि",
            branch: "खौला",
            spouse: ["kunti_ghimire"],
            children: ["vrihaspati_ghimire", "shreeram_ghimire", "annat_ghimire"]
        },
        "vrihaspati_ghimire": {
            id: "vrihaspati_ghimire",
            familyId: "family_ghimire",
            name: "वृहस्पति घिमिरे",
            nameEn: "Vrihaspati Ghimire",
            gender: "male",
            generation: 3,
            relation: "छोरा (जेठो)",
            parents: ["bhagirath_ghimire"],
            birthplace: "खौला",
            profession: "कृषि",
            branch: "खौला",
            spouse: [],
            children: ["vrishlal_ghimire", "dashrath_ghimire"]
        }
    },
    
    // शाखाहरूको विवरण
    branches: {
        "khaule": {
            id: "khaule",
            name: "खौला",
            founder: "भागीरथ जैसी घिमिरे",
            established: "वि.सं. १९५०",
            location: "अर्घाखाँची, खौला क्षेत्र",
            currentHead: "वृहस्पति जैसी घिमिरे",
            specialty: "जेठो हाँगा, परम्परागत कृषि",
            memberCount: 150,
            generations: 5
        },
        "dulikharke": {
            id: "dulikharke",
            name: "दुलिखर्के",
            founder: "धर्मागत जैसी घिमिरे",
            established: "वि.सं. १९४०",
            location: "दुलिखर्के क्षेत्र",
            currentHead: "भक्तिराम जैसी घिमिरे",
            specialty: "खोतले मुख्याको दर्जा, सामाजिक नेतृत्व",
            memberCount: 120,
            generations: 4
        },
        "bhirkune": {
            id: "bhirkune",
            name: "भिरकुने",
            founder: "धनीश्वर जैसी घिमिरे",
            established: "वि.सं. १९६०",
            location: "भिरकुने क्षेत्र, अर्घाखाँची",
            currentHead: "थानेश्वर घिमिरे",
            specialty: "व्यापार र कृषिमा संलग्न",
            memberCount: 90,
            generations: 4
        },
        "fursabhire": {
            id: "fursabhire",
            name: "फुर्साभिरे",
            founder: "हरी नारायण जैसी घिमिरे",
            established: "वि.सं. १९६५",
            location: "फुर्साभिरे क्षेत्र",
            currentHead: "नामदेव घिमिरे",
            specialty: "सबैभन्दा ठूलो शाखा, विविध व्यवसाय",
            memberCount: 200,
            generations: 5
        },
        "bainsharukhe": {
            id: "bainsharukhe",
            name: "बैँशारूखे",
            founder: "दिलाराम जैसी घिमिरे",
            established: "वि.सं. १९७०",
            location: "बैँशारूखे क्षेत्र",
            currentHead: "मनिराम घिमिरे",
            specialty: "नदी किनारको बसोबास",
            memberCount: 80,
            generations: 4
        },
        "bansharukhe": {
            id: "bansharukhe",
            name: "बाँसारूखे",
            founder: "वेदुराम जैसी घिमिरे",
            established: "वि.सं. १९७५",
            location: "बाँसारूखे क्षेत्र, देराधुम",
            currentHead: "वेदुराम घिमिरे",
            specialty: "बाँस जङ्गल नजिकको बसोबास",
            memberCount: 70,
            generations: 3
        }
    }
};

// डाटा एक्सेस हेल्पर फंक्शनहरू
const FamilyDataService = {
    // सदस्यहरू पाउनुहोस्
    getMember: function(memberId) {
        return familyData.members[memberId];
    },
    
    // परिवारको सदस्यहरू पाउनुहोस्
    getFamilyMembers: function(familyId) {
        return Object.values(familyData.members).filter(member => member.familyId === familyId);
    },
    
    // शाखाका सदस्यहरू पाउनुहोस्
    getBranchMembers: function(branchName) {
        return Object.values(familyData.members).filter(member => member.branch === branchName);
    },
    
    // विशेष पुस्ताका सदस्यहरू पाउनुहोस्
    getGenerationMembers: function(generation) {
        return Object.values(familyData.members).filter(member => member.generation === generation);
    },
    
    // शाखा जानकारी पाउनुहोस्
    getBranchInfo: function(branchId) {
        return familyData.branches[branchId];
    },
    
    // सबै शाखाहरू पाउनुहोस्
    getAllBranches: function() {
        return Object.values(familyData.branches);
    },
    
    // आमाबुवा पाउनुहोस्
    getParents: function(memberId) {
        const member = this.getMember(memberId);
        if (!member || !member.parents) return [];
        return member.parents.map(parentId => this.getMember(parentId));
    },
    
    // छोराछोरीहरू पाउनुहोस्
    getChildren: function(memberId) {
        const member = this.getMember(memberId);
        if (!member || !member.children) return [];
        return member.children.map(childId => this.getMember(childId));
    },
    
    // जीवनसाथीहरू पाउनुहोस्
    getSpouses: function(memberId) {
        const member = this.getMember(memberId);
        if (!member || !member.spouse) return [];
        return member.spouse.map(spouseId => this.getMember(spouseId));
    },
    
    // खोज गर्नुहोस्
    searchMembers: function(query) {
        const searchTerm = query.toLowerCase();
        return Object.values(familyData.members).filter(member => {
            return (
                member.name.toLowerCase().includes(searchTerm) ||
                (member.nameEn && member.nameEn.toLowerCase().includes(searchTerm)) ||
                (member.nickname && member.nickname.toLowerCase().includes(searchTerm)) ||
                (member.relation && member.relation.toLowerCase().includes(searchTerm)) ||
                (member.branch && member.branch.toLowerCase().includes(searchTerm))
            );
        });
    }
};