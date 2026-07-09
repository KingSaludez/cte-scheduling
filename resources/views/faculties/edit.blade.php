<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Edit Faculty</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <form method="POST" action="{{ route('faculties.update', $faculty) }}">
                        @csrf @method('PUT')

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <x-input-label for="full_name" value="Full Name" />
                                <x-text-input id="full_name" name="full_name" type="text" class="mt-1 block w-full" :value="old('full_name', $faculty->full_name)" required />
                                <x-input-error :messages="$errors->get('full_name')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="user_id" value="Link User Account" />
                                <select id="user_id" name="user_id" class="mt-1 block w-full border-gray-300 focus:border-primary-500 focus:ring-primary-500 rounded-md shadow-sm">
                                    <option value="">-- No account --</option>
                                    @foreach($users as $user)
                                        <option value="{{ $user->id }}" {{ old('user_id', $faculty->user->id ?? '') == $user->id ? 'selected' : '' }}>{{ $user->name }} ({{ $user->email }})</option>
                                    @endforeach
                                </select>
                                <x-input-error :messages="$errors->get('user_id')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="gender" value="Gender" />
                                <select id="gender" name="gender" class="mt-1 block w-full border-gray-300 focus:border-primary-500 focus:ring-primary-500 rounded-md shadow-sm">
                                    <option value="">Select Gender</option>
                                    <option value="male" {{ old('gender', $faculty->gender) == 'male' ? 'selected' : '' }}>Male</option>
                                    <option value="female" {{ old('gender', $faculty->gender) == 'female' ? 'selected' : '' }}>Female</option>
                                </select>
                            </div>

                            <div>
                                <x-input-label for="employment_status" value="Employment Status" />
                                <select id="employment_status" name="employment_status" class="mt-1 block w-full border-gray-300 focus:border-primary-500 focus:ring-primary-500 rounded-md shadow-sm" required>
                                    <option value="full-time" {{ old('employment_status', $faculty->employment_status) == 'full-time' ? 'selected' : '' }}>Full-time</option>
                                    <option value="part-time" {{ old('employment_status', $faculty->employment_status) == 'part-time' ? 'selected' : '' }}>Part-time</option>
                                </select>
                            </div>

                            <div>
                                <x-input-label for="academic_rank" value="Academic Rank" />
                                <select id="academic_rank" name="academic_rank" class="mt-1 block w-full border-gray-300 focus:border-primary-500 focus:ring-primary-500 rounded-md shadow-sm">
                                    <option value="">Select Rank</option>
                                    <option value="Instructor I" {{ old('academic_rank', $faculty->academic_rank) == 'Instructor I' ? 'selected' : '' }}>Instructor I</option>
                                    <option value="Instructor II" {{ old('academic_rank', $faculty->academic_rank) == 'Instructor II' ? 'selected' : '' }}>Instructor II</option>
                                    <option value="Instructor III" {{ old('academic_rank', $faculty->academic_rank) == 'Instructor III' ? 'selected' : '' }}>Instructor III</option>
                                    <option value="Assistant Professor I" {{ old('academic_rank', $faculty->academic_rank) == 'Assistant Professor I' ? 'selected' : '' }}>Assistant Professor I</option>
                                    <option value="Assistant Professor II" {{ old('academic_rank', $faculty->academic_rank) == 'Assistant Professor II' ? 'selected' : '' }}>Assistant Professor II</option>
                                    <option value="Assistant Professor III" {{ old('academic_rank', $faculty->academic_rank) == 'Assistant Professor III' ? 'selected' : '' }}>Assistant Professor III</option>
                                    <option value="Associate Professor I" {{ old('academic_rank', $faculty->academic_rank) == 'Associate Professor I' ? 'selected' : '' }}>Associate Professor I</option>
                                    <option value="Associate Professor II" {{ old('academic_rank', $faculty->academic_rank) == 'Associate Professor II' ? 'selected' : '' }}>Associate Professor II</option>
                                    <option value="Associate Professor III" {{ old('academic_rank', $faculty->academic_rank) == 'Associate Professor III' ? 'selected' : '' }}>Associate Professor III</option>
                                    <option value="Professor I" {{ old('academic_rank', $faculty->academic_rank) == 'Professor I' ? 'selected' : '' }}>Professor I</option>
                                    <option value="Professor II" {{ old('academic_rank', $faculty->academic_rank) == 'Professor II' ? 'selected' : '' }}>Professor II</option>
                                    <option value="Professor III" {{ old('academic_rank', $faculty->academic_rank) == 'Professor III' ? 'selected' : '' }}>Professor III</option>
                                    <option value="Professor IV" {{ old('academic_rank', $faculty->academic_rank) == 'Professor IV' ? 'selected' : '' }}>Professor IV</option>
                                    <option value="Professor VI" {{ old('academic_rank', $faculty->academic_rank) == 'Professor VI' ? 'selected' : '' }}>Professor VI</option>
                                    <option value="College Secretary" {{ old('academic_rank', $faculty->academic_rank) == 'College Secretary' ? 'selected' : '' }}>College Secretary</option>
                                </select>
                            </div>

                            <div>
                                <x-input-label for="educational_attainment" value="Educational Attainment" />
                                <select id="educational_attainment" name="educational_attainment" class="mt-1 block w-full border-gray-300 focus:border-primary-500 focus:ring-primary-500 rounded-md shadow-sm">
                                    <option value="">Select Attainment</option>
                                    <option value="Bachelor's Degree" {{ old('educational_attainment', $faculty->educational_attainment) == "Bachelor's Degree" ? 'selected' : '' }}>Bachelor's Degree</option>
                                    <option value="Bachelor's Degree with MA units" {{ old('educational_attainment', $faculty->educational_attainment) == "Bachelor's Degree with MA units" ? 'selected' : '' }}>Bachelor's Degree with MA units</option>
                                    <option value="Master's Degree (MAEd)" {{ old('educational_attainment', $faculty->educational_attainment) == "Master's Degree (MAEd)" ? 'selected' : '' }}>Master's Degree (MAEd)</option>
                                    <option value="Master's Degree with PhD units" {{ old('educational_attainment', $faculty->educational_attainment) == "Master's Degree with PhD units" ? 'selected' : '' }}>Master's Degree with PhD units</option>
                                    <option value="Doctorate Degree (PhD/EdD)" {{ old('educational_attainment', $faculty->educational_attainment) == "Doctorate Degree (PhD/EdD)" ? 'selected' : '' }}>Doctorate Degree (PhD/EdD)</option>
                                    <option value="Doctorate Degree (ongoing)" {{ old('educational_attainment', $faculty->educational_attainment) == "Doctorate Degree (ongoing)" ? 'selected' : '' }}>Doctorate Degree (ongoing)</option>
                                </select>
                            </div>

                            <div>
                                <x-input-label for="professional_license" value="Professional License" />
                                <select id="professional_license" name="professional_license" class="mt-1 block w-full border-gray-300 focus:border-primary-500 focus:ring-primary-500 rounded-md shadow-sm">
                                    <option value="">Select License</option>
                                    <option value="Licensed Professional Teacher (LPT)" {{ old('professional_license', $faculty->professional_license) == 'Licensed Professional Teacher (LPT)' ? 'selected' : '' }}>Licensed Professional Teacher (LPT)</option>
                                    <option value="Registered Guidance Counselor (RGC)" {{ old('professional_license', $faculty->professional_license) == 'Registered Guidance Counselor (RGC)' ? 'selected' : '' }}>Registered Guidance Counselor (RGC)</option>
                                    <option value="Registered Psychometrician" {{ old('professional_license', $faculty->professional_license) == 'Registered Psychometrician' ? 'selected' : '' }}>Registered Psychometrician</option>
                                    <option value="None" {{ old('professional_license', $faculty->professional_license) == 'None' ? 'selected' : '' }}>None</option>
                                </select>
                            </div>

                            <div>
                                <x-input-label for="specialization" value="Specialization" />
                                <select id="specialization" name="specialization" class="mt-1 block w-full border-gray-300 focus:border-primary-500 focus:ring-primary-500 rounded-md shadow-sm">
                                    <option value="">Select Specialization</option>
                                    <option value="English" {{ old('specialization', $faculty->specialization) == 'English' ? 'selected' : '' }}>English</option>
                                    <option value="Mathematics" {{ old('specialization', $faculty->specialization) == 'Mathematics' ? 'selected' : '' }}>Mathematics</option>
                                    <option value="Science" {{ old('specialization', $faculty->specialization) == 'Science' ? 'selected' : '' }}>Science</option>
                                    <option value="Filipino" {{ old('specialization', $faculty->specialization) == 'Filipino' ? 'selected' : '' }}>Filipino</option>
                                    <option value="Social Studies" {{ old('specialization', $faculty->specialization) == 'Social Studies' ? 'selected' : '' }}>Social Studies</option>
                                    <option value="Values Education" {{ old('specialization', $faculty->specialization) == 'Values Education' ? 'selected' : '' }}>Values Education</option>
                                    <option value="MAPEH" {{ old('specialization', $faculty->specialization) == 'MAPEH' ? 'selected' : '' }}>MAPEH</option>
                                    <option value="Early Childhood Education" {{ old('specialization', $faculty->specialization) == 'Early Childhood Education' ? 'selected' : '' }}>Early Childhood Education</option>
                                    <option value="Special Education" {{ old('specialization', $faculty->specialization) == 'Special Education' ? 'selected' : '' }}>Special Education</option>
                                    <option value="General Education" {{ old('specialization', $faculty->specialization) == 'General Education' ? 'selected' : '' }}>General Education</option>
                                    <option value="Educational Management" {{ old('specialization', $faculty->specialization) == 'Educational Management' ? 'selected' : '' }}>Educational Management</option>
                                    <option value="Guidance and Counseling" {{ old('specialization', $faculty->specialization) == 'Guidance and Counseling' ? 'selected' : '' }}>Guidance and Counseling</option>
                                    <option value="Technology and Livelihood Education" {{ old('specialization', $faculty->specialization) == 'Technology and Livelihood Education' ? 'selected' : '' }}>Technology and Livelihood Education</option>
                                    <option value="Physical Education" {{ old('specialization', $faculty->specialization) == 'Physical Education' ? 'selected' : '' }}>Physical Education</option>
                                </select>
                            </div>
                        </div>

                        <div class="mt-6">
                            <x-input-label value="Qualified Subjects" />
                            <div class="mt-2 grid grid-cols-1 md:grid-cols-3 gap-2">
                                @php $selected = old('qualifications', $faculty->qualifications->pluck('subject_id')->toArray()); @endphp
                                @forelse($subjects as $subject)
                                    <label class="inline-flex items-center">
                                        <input type="checkbox" name="qualifications[]" value="{{ $subject->id }}" class="rounded border-gray-300 text-primary-600 shadow-sm focus:ring-primary-500" {{ in_array($subject->id, $selected) ? 'checked' : '' }}>
                                        <span class="ms-2 text-sm text-gray-600">{{ $subject->code }} - {{ $subject->title }}</span>
                                    </label>
                                @empty
                                    <p class="text-sm text-gray-500">No subjects available.</p>
                                @endforelse
                            </div>
                        </div>

                        <div class="flex items-center gap-4 mt-6">
                            <button type="submit" class="bg-primary-600 hover:bg-primary-700 text-white font-bold py-2 px-4 rounded">Update</button>
                            <a href="{{ route('faculties.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
