<div id="opnameModal"
     class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black/50">

    <div class="bg-white w-full max-w-lg rounded-lg shadow-lg p-6">

        <h3 class="text-lg font-semibold mb-4">
            Add Opname Item
        </h3>

        <form id="opnameForm" class="space-y-4">

            <select id="opnameProduct" class="w-full border p-2">
                <option value="">Select product</option>
                @foreach($products as $p)
                    <option value="{{ $p->id }}">{{ $p->name }}</option>
                @endforeach
            </select>

            <input id="categoryName"
                   readonly
                   class="w-full border p-2 bg-gray-100"
                   placeholder="Category">

            <input id="systemStock" readonly
                   class="w-full border p-2 bg-gray-100"
                   placeholder="System stock">

            <input id="physicalStock" type="number" min="0"
                   class="w-full border p-2"
                   placeholder="Physical stock">

            <input id="differenceStock" readonly
                   class="w-full border p-2 bg-gray-100"
                   placeholder="Difference">

            <textarea id="itemNotes"
                      class="w-full border p-2"
                      placeholder="Notes / explanation (optional)"></textarea>

            <div class="flex justify-end gap-2">
                <button type="button" id="closeModal"
                        class="px-4 py-2 rounded-md
                            bg-gray-200 text-gray-700
                            hover:bg-gray-300
                            active:bg-gray-400
                            focus:outline-none focus:ring-2 focus:ring-gray-300
                            transition-all duration-200">
                            
                    Close
                </button>

                <button type="button" id="addItemBtn"
                        class="px-4 py-2 rounded-md
                            bg-yellow-500 text-white
                            hover:bg-yellow-600
                            active:bg-yellow-700
                            focus:outline-none focus:ring-2 focus:ring-yellow-400
                            transition-all duration-200">

                    Add Item
                </button>
            </div>

        </form>

    </div>
</div>
